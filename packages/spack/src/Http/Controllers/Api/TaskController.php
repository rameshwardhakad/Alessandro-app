<?php

namespace Spack\Http\Controllers\Api;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spack\Models\Attachment;
use Spack\Models\Checklist;
use Spack\Models\Comment;
use Spack\Models\Project;
use Spack\Models\ProjectList;
use Spack\Models\Task;
use Spack\Notifications\TaskAssigned;

class TaskController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('can:task:create', only: ['store']),
            new Middleware('can:task:update', only: ['title', 'description', 'duedate', 'assign', 'unassign', 'list']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Task::query();

        $query
            ->whereHas('users', function (Builder $q) {
                $q->where('id', auth()->id());
            })
            ->with('project', 'users')
            ->whereNull('parent_id');

        if (request('type') == 'today') {
            return ['today' => $query->whereNull('completed_at')->whereDate('due_at', today())->get()];
        } elseif (request('type') == 'upcoming') {
            return ['upcoming' => $query->whereNull('completed_at')->whereDate('due_at', '>', today())->get()];
        } elseif (request('type') == 'overdue') {
            return ['overdue' => $query->whereNull('completed_at')->whereDate('due_at', '<', today())->get()];
        } elseif (request('type') == 'completed') {
            return ['completed' => $query->whereNotNull('completed_at')->get()];
        }

        if (request('project')) {
            $query->where('project_id', request('project'));
        }

        return $query->whereNull('completed_at')->get()
            ->groupBy(function ($item) {
                if (! $item->due_at) {
                    return 'no due date';
                }

                if ($item->due_at->isToday()) {
                    return 'today';
                }

                if ($item->due_at->isFuture()) {
                    return 'upcoming';
                }

                if ($item->due_at->isPast()) {
                    return 'overdue';
                }
            });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'project_list_id' => 'required|integer',
            'title' => 'required|string|max:100',
        ]);

        $task = Task::create([
            'project_id' => $request->project_id,
            'project_list_id' => $request->project_list_id,
            'title' => $request->title,
            'order' => Task::whereProjectListId($request->project_list_id)->max('order') + 1,
        ]);

        return [
            'message' => 'Project List created successfully',
            'model' => $task,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $taskModel = Task::whereId($id)->first();
        $task = $taskModel->only(['id', 'title', 'description', 'due_at']);
        $project = Project::whereId($taskModel->project_id)->first(['id', 'name', 'meta']);
        $list = ProjectList::whereId($taskModel->project_list_id)->first(['id', 'name']);
        $listOptions = ProjectList::whereProjectId($taskModel->project_id)->get([
            'id as value',
            'name as label',
        ]);
        $userOptions = User::whereHas('projects', function (Builder $q) use ($taskModel) {
            $q->where('project_id', $taskModel->project_id);
        })->get(['id', 'name', 'email', 'avatar']);
        $checklists = Checklist::whereTaskId($id)
            ->with('items')
            ->get();
        $comments = Comment::whereTaskId($id)
            ->with('user', 'attachments')
            ->get();
        $users = $taskModel->users()->get(['id', 'name', 'email', 'avatar']);

        if ($task['due_at']) {
            $task['human_due_date'] = Carbon::parse($task['due_at'])->toFormattedDateString();
        } else {
            $task['human_due_date'] = null;
        }

        $attachments = Attachment::whereTaskId($id)->get();

        return compact('task', 'project', 'list', 'listOptions', 'userOptions', 'checklists', 'comments', 'users', 'attachments');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function duedate(Request $request, Task $task)
    {
        $task->update([
            'due_at' => $request->due_at,
        ]);
    }

    /**
     * Archive the specified resource from storage.
     */
    public function archive(Task $task)
    {
        $task->archive();
    }

    /**
     * Archive the specified resource from storage.
     */
    public function list(Task $task, Request $request)
    {
        $task->update([
            'project_list_id' => $request->project_list_id,
        ]);

        return [
            'message' => 'Task moved successfully',
        ];
    }

    /**
     * Archive the specified resource from storage.
     */
    public function assign(Task $task, Request $request)
    {
        $task->users()->attach($request->user);

        $user = User::find($request->user);

        $user->notify(new TaskAssigned($task));
    }

    /**
     * Archive the specified resource from storage.
     */
    public function unassign(Task $task, Request $request)
    {
        $task->users()->detach($request->user);
    }

    /**
     * Archive the specified resource from storage.
     */
    public function comments(Task $task, Request $request)
    {
        $comment = $task->comments()->create([
            'user_id' => $request->user()->id,
            'text' => $request->text,
        ]);

        foreach ($request->attachments as $attachment) {
            $path = public_path($attachment['path']);
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            $mime = mime_content_type($path);
            $isImage = strpos($mime, 'image/') === 0;

            Attachment::create([
                'user_id' => auth()->id(),
                'project_id' => $request->project_id,
                'task_id' => $task->id,
                'comment_id' => $comment->id,
                'path' => $attachment['path'],
                'name' => $attachment['name'],
                'extension' => $extension,
                'is_image' => $isImage,
                'mime_type' => $mime,
            ]);
        }

        $comment->load('user', 'attachments');

        return [
            'message' => 'Comment created successfully',
            'model' => $comment,
        ];
    }

    /**
     * Archive the specified resource from storage.
     */
    public function title(Task $task, Request $request)
    {
        $task->update([
            'title' => $request->title,
        ]);

        return [
            'message' => 'Title updated successfully',
            'model' => $task,
        ];
    }

    /**
     * Archive the specified resource from storage.
     */
    public function description(Task $task, Request $request)
    {
        $task->update([
            'description' => $request->description,
        ]);

        return [
            'message' => 'Description updated successfully',
            'model' => $task,
        ];
    }
}

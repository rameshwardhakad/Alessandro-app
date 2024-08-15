<?php

namespace Spack\Http\Controllers\Api;

use AhsanDev\Support\Arr;
use AhsanDev\Support\Field;
use App\Models\User;
use Facades\Spack\Static\Color;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Arr as LaravelArr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spack\Models\Project;
use Spack\Notifications\ProjectAssigned;
use Spack\Support\SidebarProject;

class ProjectController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('can:project:create', only: ['create', 'store']),
            new Middleware('can:project:add/remove-user', only: ['users']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Project::simplePaginate($request->per_page ?? option('per_page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project)
    {
        return $this->fields($project);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                'min:2',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tenant_id', session('tenant_id'));
                }),
            ],
            'color' => 'required|string|hex_color',
        ]);

        $project = Project::create([
            'name' => $request->name,
            'order' => Project::max('order') + 1,
            'meta' => ['color' => $request->color],
        ]);

        $project->users()->attach(auth()->id());

        (new SidebarProject())->updateCache();

        return [
            'message' => 'Project created successfully',
            'model' => $project,
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        if (! Auth::user()->isAdmin() && ! Auth::user()->projects->contains($project)) {
            abort(403);
        }

        return [
            ...$project->toArray(),
            'users' => $project
                ->users()
                ->get(['id', 'name', 'email', 'avatar'])
                ->makeHidden(['pivot']),

            // 'lists' => ProjectList::whereProjectId($project->id)->with('tasks')->get(),
            'lists' => $project
                ->lists()
                ->with([
                    'tasks' => function ($query) {
                        $query
                            ->withCount([
                                'comments',
                                'subtasks',
                                'subtasks as completed_subtasks_count' => fn ($query) => $query->whereNotNull('completed_at'),
                                'users',
                            ])
                            ->with('users')
                            ->orderBy('order');
                    },
                ])
                ->orderBy('order')
                ->get(),
            'colorOptions' => Color::options(),
        ];
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $attributes = $request->validate([
            'name' => 'sometimes|required|string|max:100|min:2',
            'color' => 'sometimes|required|string|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $attributes = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                'min:2',
                Rule::unique('projects')->where(function ($query) use ($request) {
                    return $query->where('tenant_id', session('tenant_id'));
                })->ignore($project->id),
            ],
            'color' => 'sometimes|required|string|regex:/^#[0-9a-fA-F]{6}$/',
        ]);

        $project->update(Arr::wrapInMeta($attributes, ['color']));

        (new SidebarProject())->updateCache();

        return [
            'message' => 'Project updated successfully',
            'model' => $project,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return ['message' => 'Project deleted successfully'];
    }

    /**
     * Archive the specified resource from storage.
     */
    public function archive(Project $project)
    {
        $project->archive();

        (new SidebarProject())->updateCache();

        return ['message' => 'Project archived successfully'];
    }

    /**
     * UnArchive the specified resource from storage.
     */
    public function unarchive($id)
    {
        Project::withArchived()
            ->findOrFail($id)
            ->unarchive();

        (new SidebarProject())->updateCache();

        return ['message' => 'Project unarchived successfully'];
    }

    /**
     * Sort the specified resource from storage.
     */
    public function sort(Project $project, Request $request)
    {
        $request->validate([
            'order' => 'required|integer',
        ]);

        $newOrder = $request->order;
        $oldOrder = $project->order;

        if ($newOrder == $oldOrder) {
            return ['message' => 'Project sorted successfully'];
        }

        Project::where('id', '<>', $project->id)
            ->whereBetween('order', LaravelArr::sort([$newOrder, $oldOrder]))
            ->increment('order', $oldOrder <=> $newOrder);

        $project->update(['order' => $newOrder]);

        return ['message' => 'Project sorted successfully'];
    }

    /**
     * Sync the project users.
     */
    public function users(Project $project, Request $request)
    {
        $currentUsers = $project->users()->pluck('id')->toArray();

        $project->users()->sync($request->users);

        $userIds = array_values(array_diff($request->users, array_intersect($currentUsers, $request->users)));

        User::whereIn('id', $userIds)->get()->each->notify(new ProjectAssigned($project));

        return $project
            ->users()
            ->get(['id', 'name', 'email', 'avatar'])
            ->makeHidden(['pivot']);
    }

    public function fields($model)
    {
        return Field::make()
            ->field('name', $model->name)
            ->field('color', $model->meta['color'] ?? Color::default(), Color::options());
    }
}

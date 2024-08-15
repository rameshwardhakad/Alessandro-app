<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spack\Models\Task;

class TaskMove implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return ['can:task:move'];
    }

    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, Task $task)
    {
        $task->update([
            'project_list_id' => $request->to_list,
            'order' => $request->new_index,
        ]);

        // Old list
        $oldListTasks = Task::whereProjectId($request->project_id)
            ->whereNull('parent_id')
            ->where('project_list_id', $request->from_list)
            ->where('order', '>', $request->old_index)
            ->orderBy('order')
            ->get();

        foreach ($oldListTasks as $oldListTask) {
            $oldListTask->update([
                'order' => $oldListTask->order - 1,
            ]);
        }

        // New list
        $newListTasks = Task::whereProjectId($request->project_id)
            ->whereNull('parent_id')
            ->where('project_list_id', $request->to_list)
            ->where('order', '>=', $request->new_index)
            ->where('id', '!=', $task->id)
            ->orderBy('order')
            ->get();

        foreach ($newListTasks as $newListTask) {
            $newListTask->update([
                'order' => $newListTask->order + 1,
            ]);
        }

        return ['status' => 'done'];
    }
}

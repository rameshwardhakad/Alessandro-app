<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Spack\Models\Task;

class TaskSort implements HasMiddleware
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
        if ($request->old_index < $request->new_index) {
            $startDirection = '>=';
            $endDirection = '<=';
            $sign = -1;
        } elseif ($request->old_index > $request->new_index) {
            $startDirection = '<=';
            $endDirection = '>=';
            $sign = 1;
        }

        Task::whereId($request->id)->update([
            'order' => $request->new_index,
        ]);

        $tasks = Task::whereProjectId($request->project_id)
            ->whereNull('parent_id')
            ->where('project_list_id', $task->project_list_id)
            ->where('order', $startDirection, $request->old_index)
            ->where('order', $endDirection, $request->new_index)
            ->where('id', '!=', $request->id)
            ->orderBy('order')
            ->get();

        foreach ($tasks as $task) {
            $task->update([
                'order' => $task->order + $sign,
            ]);
        }

        return ['status' => 'done'];
    }
}

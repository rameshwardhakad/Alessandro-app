<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Arr;
use Spack\Models\ProjectList;

class ProjectListSortController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return ['can:project-list:update'];
    }

    /**
     * Sorting Project Lists.
     */
    public function __invoke(Request $request, ProjectList $projectList)
    {
        $newOrder = $request->order;
        $oldOrder = $projectList->order;

        if ($newOrder == $oldOrder) {
            return ['message' => 'Project list sorted successfully'];
        }

        ProjectList::where('id', '<>', $projectList->id)
            ->whereProjectId($request->project_id)
            ->whereBetween('order', Arr::sort([$newOrder, $oldOrder]))
            ->increment('order', $oldOrder <=> $newOrder);

        $projectList->update(['order' => $newOrder]);

        return ['message' => 'Project list sorted successfully'];
    }
}

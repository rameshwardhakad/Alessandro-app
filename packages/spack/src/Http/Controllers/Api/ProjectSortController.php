<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spack\Models\Project;

class ProjectSortController
{
    /**
     * Sorting Projects.
     */
    public function __invoke(Project $project, Request $request)
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
            ->whereBetween('order', Arr::sort([$newOrder, $oldOrder]))
            ->increment('order', $oldOrder <=> $newOrder);

        $project->update(['order' => $newOrder]);

        return ['message' => 'Project sorted successfully'];
    }
}

<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Project;

class ProjectsAllController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'limit' => 'nullable|integer|min:0',
        ]);

        $projects = Project::select('id', 'name', 'order', 'meta')
            ->orderByRaw('CASE WHEN `order` = 0 THEN 1 ELSE 0 END, `order` ASC');

        if ($limit = $request->limit) {
            $projects->limit($limit);
        }

        if ($archived = $request->has('archived')) {
            $projects->onlyArchived($archived);
        }

        return $projects
            ->get()
            ->map(function ($project) {
                $project->meta = is_string($project->meta) ? json_decode($project->meta, true) : $project->meta;

                return $project;
            });
    }
}

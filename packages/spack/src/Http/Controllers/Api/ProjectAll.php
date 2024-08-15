<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectAll
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'limit' => 'nullable|integer|min:0',
        ]);

        $projects = DB::table('projects')
            ->select('id', 'name', 'meta')
            ->where('archived_at', null)
            ->where('deleted_at', null)
            ->where('tenant_id', session('tenant_id'))
            ->orderBy('order');

        if (! auth()->user()->isAdmin()) {
            $projects->join('project_user', 'projects.id', '=', 'project_user.project_id')
                ->where('project_user.user_id', auth()->id());
        }

        if ($limit = $request->limit) {
            $projects->limit($limit);
        }

        return $projects
            ->get()
            ->map(function ($project) {
                $project->meta = json_decode($project->meta, true);

                return $project;
            });
    }
}

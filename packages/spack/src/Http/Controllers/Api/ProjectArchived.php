<?php

namespace Spack\Http\Controllers\Api;

use Spack\Models\Project;

class ProjectArchived
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $project = Project::query();

        if (! auth()->user()->isSuperAdmin()) {
            $project->whereHas('users', function ($q) {
                $q->whereId(auth()->id());
            });
        }

        return $project->onlyArchived()->get();
    }
}

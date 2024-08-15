<?php

namespace Spack\Http\Controllers\Api;

use Spack\Models\Project;

class ProjectArchiveController
{
    /**
     * archive the specified project from storage.
     */
    public function archive(Project $project)
    {
        $project->archive();

        return ['message' => 'Project archived successfully'];
    }
}

<?php

namespace Spack\Http\Controllers\Api;

use Spack\Models\ProjectList;

class ProjectListArchiveController
{
    /**
     * archive the specified project list from storage.
     */
    public function archive(ProjectList $projectList)
    {
        $projectList->archive();

        return ['message' => 'Project list archived successfully'];
    }
}

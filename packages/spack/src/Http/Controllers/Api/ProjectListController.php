<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Spack\Models\Project;
use Spack\Models\ProjectList;

class ProjectListController implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('can:project-list:create', only: ['store']),
            new Middleware('can:project-list:update', only: ['update']),
            new Middleware('can:project-list:delete', only: ['delete']),
        ];
    }

    /**
     * Display a lists of the project.
     */
    public function index(Request $request)
    {
        $project = Project::find($request->project_id);

        $projectLists = $project->projectLists;

        return $projectLists;
    }

    /**
     * Store a newly created project lists in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer',
            'name' => 'required|string|min:1|max:100',
            // 'order' => 'integer|min:0',
        ]);

        $projectList = ProjectList::create([
            'project_id' => $request->project_id,
            'name' => $request->name,
            'order' => ProjectList::whereProjectId($request->project_id)->max('order') + 1,
        ]);

        return [
            'message' => 'Project List created successfully',
            'model' => $projectList,
        ];
    }

    /**
     * Update the specified project list in storage.
     */
    public function update(Request $request, ProjectList $projectList)
    {
        $request->validate([
            'name' => 'required|string|min:1|max:100',
        ]);

        $projectList->update([
            'name' => $request->name,
        ]);

        return [
            'message' => 'Project list updated successfully',
            'model' => $projectList,
        ];
    }

    /**
     * Remove the specified project list from storage.
     */
    public function delete(ProjectList $projectList)
    {
        $projectList->tasks()->each(fn ($item) => $item->users()->detach());
        $projectList->tasks()->each(fn ($item) => $item->subtasks()->forceDelete());
        $projectList->tasks()->each(fn ($item) => $item->comments()->forceDelete());
        $projectList->tasks()->each(fn ($item) => $item->attachments()->forceDelete());
        $projectList->tasks()->forceDelete();
        $projectList->forceDelete();

        return ['message' => 'Project List deleted successfully'];
    }

    /**
     * Remove the specified project list from storage.
     */
    public function sort(Request $request)
    {
    }
}

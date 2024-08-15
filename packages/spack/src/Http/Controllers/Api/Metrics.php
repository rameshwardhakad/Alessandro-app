<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Spack\Models\Project;
use Spack\Models\Task;

class Metrics
{
    public function __invoke(): array
    {
        if (Auth::user()->isAdmin()) {
            return [
                'open_tasks' => Task::whereNull('parent_id')->whereNull('completed_at')->count(),
                'completed_tasks' => Task::whereNull('parent_id')->whereNotNull('completed_at')->count(),
                'total_projects' => Project::count(),
            ];
        }

        return [
            'open_tasks' => Task::whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })->whereNull('parent_id')->whereNull('completed_at')->count(),

            'completed_tasks' => Task::whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })->whereNull('parent_id')->whereNotNull('completed_at')->count(),

            'total_projects' => Project::whereHas('users', function (Builder $query) {
                $query->where('id', auth()->id());
            })->count(),
        ];
    }
}

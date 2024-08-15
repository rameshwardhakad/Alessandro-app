<?php

namespace Spack\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use JsonSerializable;

class SidebarProject implements JsonSerializable
{
    /**
     * Fetch projects from the database.
     */
    protected function projects(): array
    {
        $userId = auth()->id();
        $isAdmin = auth()->user()->isAdmin();

        $query = DB::table('projects')
            ->select('projects.id', 'projects.name', 'projects.meta')
            ->whereNull('projects.archived_at')
            ->whereNull('projects.deleted_at')
            ->where('tenant_id', session('tenant_id'))
            ->limit(10);

        if (! $isAdmin) {
            $query->join('project_user', 'projects.id', '=', 'project_user.project_id')
                ->where('project_user.user_id', $userId);
        }

        return $query->get()
            ->map(fn ($project) => tap(
                $project,
                fn ($item) => $item->meta = json_decode($item->meta, true)
            ))
            ->all();
    }

    /**
     * Update the cache with the current set of projects.
     */
    public function updateCache(): void
    {
        Cache::forever('sidebar_projects', $this->projects());
    }

    /**
     * Retrieve the projects for JSON serialization.
     */
    public function jsonSerialize(): array
    {
        // dd( $this->projects() );
        return $this->projects();

        return Cache::rememberForever('sidebar_projects', fn () => $this->projects());
    }
}

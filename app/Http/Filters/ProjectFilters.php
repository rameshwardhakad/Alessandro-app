<?php

namespace App\Http\Filters;

use App\Support\Filters\Filters;

class ProjectFilters extends Filters
{
    /**
     * Get the filters available for the resource.
     *
     * @return array
     */
    public function filters()
    {
        return [
            new ProjectStatus,
            new ProjectArchived,
        ];
    }
}

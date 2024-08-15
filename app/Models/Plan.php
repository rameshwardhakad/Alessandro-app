<?php

namespace App\Models;

use Admin\Http\Filters\PlanFilters;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'meta' => 'array',
        ];
    }

    /**
     * Apply all relevant filters.
     */
    public function scopeFilter($query, PlanFilters $filters)
    {
        return $filters->apply($query);
    }
}

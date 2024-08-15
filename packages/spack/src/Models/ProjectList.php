<?php

namespace Spack\Models;

use AhsanDev\Support\Archivable;
use App\Support\Tenantable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectList extends Model
{
    use Archivable, HasFactory, SoftDeletes, Tenantable;

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(option('date_format'));
    }

    /**
     * Get the project that owns the project list.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the tasks for the project list.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}

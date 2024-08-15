<?php

namespace Spack\Models;

use AhsanDev\Support\Archivable;
use App\Models\User;
use App\Support\Tenantable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use Archivable, HasFactory, SoftDeletes, Tenantable;

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'meta' => 'array',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format(option('date_format'));
    }

    /**
     * Get the number of models to return per page.
     */
    public function getPerPage(): int
    {
        return option('per_page');
    }

    /**
     * Get the lists for the project.
     */
    public function lists(): HasMany
    {
        return $this->hasMany(ProjectList::class);
    }

    /**
     * The users that belong to the project.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

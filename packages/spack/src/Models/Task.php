<?php

namespace Spack\Models;

use AhsanDev\Support\Archivable;
use App\Models\User;
use App\Support\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use Archivable, HasFactory, Tenantable;

    protected $appends = ['human_due_date'];

    protected function casts(): array
    {
        return [
            'due_at' => 'date:Y-m-d',
        ];
    }

    public function getHumanDueDateAttribute()
    {
        return $this->due_at ? $this->due_at->toFormattedDateString() : null;
    }

    /**
     * Get the project that owns the task.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the list that owns the task.
     */
    public function list(): BelongsTo
    {
        return $this->belongsTo(ProjectList::class, 'project_list_id');
    }

    /**
     * Get the comments for the task.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the attachments for the task.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(Attachment::class);
    }

    /**
     * Get the subtasks for the task.
     */
    public function subtasks(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }

    /**
     * The users that belong to the task.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}

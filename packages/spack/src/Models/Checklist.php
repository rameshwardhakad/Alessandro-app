<?php

namespace Spack\Models;

use App\Support\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checklist extends Model
{
    use HasFactory, Tenantable;

    /**
     * Get the items for the checklist.
     */
    public function items(): HasMany
    {
        return $this->hasMany(ChecklistItem::class);
    }
}

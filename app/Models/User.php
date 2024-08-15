<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Admin\Http\Filters\CustomerFilters;
use AhsanDev\Support\Authorization\Authorizable;
use AhsanDev\Support\Optionable;
use App\Support\Tenantable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Cashier\Billable;
use Spack\Http\Filters\UserFilters;
use Spack\Models\Project;

class User extends Authenticatable
{
    use Authorizable, Billable, HasFactory, Notifiable, Optionable, Tenantable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_customer',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The projects that belong to the user.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * The user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->roles()->where('role_id', 1)->exists();
    }

    /**
     * The user is customer.
     */
    public function isCustomer(): bool
    {
        return $this->is_customer;
    }

    /**
     * Get user permissions
     */
    public function allPermissions(): Collection
    {
        if ($this->id == 1) {
            return Permission::pluck('name');
        }

        return $this->roles->first()->permissions->pluck('name');
    }

    /**
     * Apply all relevant filters.
     */
    public function scopeFilter($query, UserFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Apply all relevant filters.
     */
    public function scopeCustomerFilter($query, CustomerFilters $filters)
    {
        return $filters->apply($query);
    }
}

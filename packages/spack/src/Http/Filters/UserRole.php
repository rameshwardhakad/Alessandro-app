<?php

namespace Spack\Http\Filters;

use AhsanDev\Support\Filters\Filter;
use App\Models\Role;

class UserRole extends Filter
{
    /**
     * The filter's component.
     *
     * @var string
     */
    public $component = 'filter-select';

    /**
     * The attribute / column name of the field.
     *
     * @var string
     */
    public $attribute = 'role';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query, $value)
    {
        return $query->whereHas('roles', function ($q) use ($value) {
            $q->where('id', $value);
        });
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options()
    {
        return Role::pluck('id', 'name');
    }
}

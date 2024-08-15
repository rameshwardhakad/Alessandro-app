<?php

namespace Spack\Http\Filters;

use AhsanDev\Support\Filters\Filter;
use App\Models\Status;

class ProjectStatus extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @var string
     */
    public $name = 'Status';

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
    public $attribute = 'status';

    /**
     * Apply the filter to the given query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function apply($query, $value)
    {
        return $query->where('status_id', $value);
    }

    /**
     * Get the filter's available options.
     *
     * @return array
     */
    public function options()
    {
        return Status::pluck('id', 'name');
    }
}

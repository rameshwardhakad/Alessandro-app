<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Filters\PlanFilters;
use Admin\Http\Requests\PlanRequest;
use AhsanDev\Support\Field;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController
{
    /**
     * Display a listing of the resource.
     */
    public function index(PlanFilters $filters)
    {
        return Plan::filter($filters)->simplePaginate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Plan $plan)
    {
        return $this->fields($plan);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Plan $plan)
    {
        return new PlanRequest($request, $plan);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $query = Plan::whereId($id);

        return $query->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        return $this->fields($plan);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Plan $plan)
    {
        return new PlanRequest($request, $plan);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // i have to implement delete prevention while plans is used.

        $plan = Plan::find($request->items[0]);
        $plan->delete();

        return [
            'message' => count($request->items) > 1
                ? 'Plans Deleted Successfully!'
                : 'Plan Deleted Successfully!'
        ];
    }

    /**
     * Archive the specified resource from storage.
     */
    public function archive(Plan $plan, Request $request)
    {
        if ($plan->archived_at) {
            $plan->update(['archived_at' => null]);
            return ['success' => true, 'message' => 'Plan restore successfully!'];
        }

        $plan->update(['archived_at' => now()]);
        return ['success' => true, 'message' => 'Plan archived successfully!'];
    }

    /**
     * Get the fields for the resource.
     */
    protected function fields($model)
    {
        return Field::make()
                ->field('name', $model->name)
                ->field('short_description', $model->meta ? $model->meta['short_description'] : null)
                ->field('monthly_price', $model->meta ? $model->meta['monthly_price'] : null)
                ->field('stripe_plan_id', $model->meta ? $model->meta['stripe_plan_id'] : null)
                ->field('projects', $model->meta ? $model->meta['projects'] : null)
                ->field('users', $model->meta ? $model->meta['users'] : null)
                ->field('features', $model->meta ? implode("\n", $model->meta['features']) : null);
    }
}

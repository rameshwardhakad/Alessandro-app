<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Requests\FrontFeatureRequest;
use AhsanDev\Support\Field;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontFeatureController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentId = Category::whereName('Front Site Feature')->first();

        return Category::whereParentId($parentId->id)->simplePaginate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $feature)
    {
        return $this->fields($feature);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $feature)
    {
        return new FrontFeatureRequest($request, $feature);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $feature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $feature)
    {
        return $this->fields($feature);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $feature)
    {
        return new FrontFeatureRequest($request, $feature);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Category::destroy($request->items);

        return [
            'message' => count($request->items) > 1
                ? 'Features Deleted Successfully!'
                : 'Feature Deleted Successfully!'
        ];
    }

    public function fields($model)
    {
        return Field::make()
                ->field('title', $model->name)
                ->field('description', $model->meta ? $model->meta['description'] : null);
    }
}

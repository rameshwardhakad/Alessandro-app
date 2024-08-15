<?php

namespace Admin\Http\Controllers\Api;

use Admin\Http\Requests\FrontFaqRequest;
use AhsanDev\Support\Field;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontFaqController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parentId = Category::whereName('Front Site Faq')->first();

        return Category::whereParentId($parentId->id)->simplePaginate();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Category $faq)
    {
        return $this->fields($faq);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $faq)
    {
        return new FrontFaqRequest($request, $faq);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $faq)
    {
        return $this->fields($faq);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $faq)
    {
        return new FrontFaqRequest($request, $faq);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Category::destroy($request->items);

        return [
            'message' => count($request->items) > 1
                ? 'Faqs Deleted Successfully!'
                : 'Faq Deleted Successfully!'
        ];
    }

    public function fields($model)
    {
        return Field::make()
                ->field('title', $model->name)
                ->field('description', $model->meta ? $model->meta['description'] : null);
    }
}

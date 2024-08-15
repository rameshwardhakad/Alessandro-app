<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Label;

class LabelController
{
    /**
     * Display a listing of the label.
     */
    public function index()
    {
        $labels = Label::get();

        return $labels;
    }

    /**
     * Show the form for creating a new label.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created label in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'order' => 'integer|min:0',
            'meta' => 'required|string',
        ]);

        $labels = Label::create([
            'name' => $request->name,
            'order' => $request->input('order', 0),
            'meta' => $request->meta,
        ]);

        return [
            'message' => 'Label created successfully',
            'model' => $labels,
        ];
    }

    /**
     * Display the specified label.
     */
    public function show(Label $label)
    {
        //
    }

    /**
     * Show the form for editing the specified label.
     */
    public function edit(Label $label)
    {
        //
    }

    /**
     * Update the specified label in storage.
     */
    public function update(Request $request, Label $label)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
            'meta' => 'required|string',
        ]);

        $label->update([
            'name' => $request->name,
            'meta' => $request->meta,
        ]);

        return [
            'message' => 'Label updated successfully',
            'model' => $label,
        ];
    }

    /**
     * Remove the specified label from storage.
     */
    public function delete(Label $label)
    {
        $label->delete();

        return ['message' => 'Label deleted successfully!'];
    }
}

<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Checklist;

class ChecklistController
{
    /**
     * Display a listing of the checklist.
     */
    public function index()
    {
        $checklists = Checklist::get();

        return $checklists;
    }

    /**
     * Show the form for creating a new checklist.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created checklist in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'name' => 'required|string|max:100|min:2',
            'order' => 'integer|min:0',
        ]);

        $checklists = Checklist::create([
            'task_id' => $request->task_id,
            'name' => $request->name,
            'order' => $request->input('order', 0),
        ]);

        return [
            'message' => 'Checklist created successfully',
            'model' => $checklists,
        ];
    }

    /**
     * Display the specified checklist.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified checklist.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified checklist in storage.
     */
    public function update(Request $request, Checklist $checklist)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
        ]);

        $checklist->update([
            'name' => $request->name,
        ]);

        return [
            'message' => 'Checklist updated successfully',
            'model' => $checklist,
        ];
    }

    /**
     * Remove the specified checklist from storage.
     */
    public function delete(Checklist $checklist)
    {
        $checklist->delete();

        return ['message' => 'Checklist deleted successfully!'];
    }
}

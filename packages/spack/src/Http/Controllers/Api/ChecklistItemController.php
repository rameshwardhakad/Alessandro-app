<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Checklist;
use Spack\Models\ChecklistItem;

class ChecklistItemController
{
    /**
     * Display a listing of the checklistItem.
     */
    public function index()
    {
        $checklistItems = ChecklistItem::get();

        return $checklistItems;
    }

    /**
     * Show the form for creating a new checklistItem.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created checklistItem in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'checklist_id' => 'integer',
            'name' => 'required|string|max:100|min:2',
            'order' => 'integer|min:0',
        ]);

        if (! $request->checklist_id) {
            $checklist = Checklist::create([
                'name' => 'Checklist',
                'task_id' => $request->task_id,
            ])->id;
        } else {
            $checklist = $request->checklist_id;
        }

        $checklistItems = ChecklistItem::create([
            'task_id' => $request->task_id,
            'checklist_id' => $checklist,
            'name' => $request->name,
            'order' => $request->input('order', 0),
        ]);

        return [
            'message' => 'Checklist Item created successfully',
            'model' => $checklistItems,
        ];
    }

    /**
     * Display the specified checklistItem.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified checklistItem.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified checklistItem in storage.
     */
    public function update(Request $request, ChecklistItem $checklistItem)
    {
        $request->validate([
            'name' => 'required|string|max:100|min:2',
        ]);

        $checklistItem->update([
            'name' => $request->name,
        ]);

        return [
            'message' => 'Checklist Item updated successfully',
            'model' => $checklistItem,
        ];
    }

    /**
     * Update the specified checklistItem in storage.
     */
    public function toggle(ChecklistItem $checklistItem)
    {
        $checklistItem->update([
            'completed_at' => $checklistItem->completed_at ? null : now(),
        ]);

        return [
            'message' => 'Checklist Item updated successfully',
            'model' => $checklistItem,
        ];
    }

    /**
     * Remove the specified checklistItem from storage.
     */
    public function delete(ChecklistItem $checklistItem)
    {
        $checklistItem->delete();

        return ['message' => 'Checklist Item deleted successfully!'];
    }
}

<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Attachment;

class AttachmentController
{
    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $path = $request->file('file')->store('files');

        return Attachment::create([
            'user_id' => auth()->id(),
            'task_id' => $request->task_id,
            'project_id' => $request->project_id,
            'name' => $request->name,
            'path' => $path,
            'extension' => $request->file('file')->extension(),
            'mime_type' => $request->file('file')->getClientMimeType(),
            'size' => $request->file('file')->getSize(),
            'is_image' => strpos($request->file('file')->getClientMimeType(), 'image/') === 0,
        ]);
    }

    /**
     * Remove the specified comment from storage.
     */
    public function delete(Attachment $attachment)
    {
        $attachment->delete();

        return [
            'message' => 'Attachment deleted successfully!'
        ];
    }
}

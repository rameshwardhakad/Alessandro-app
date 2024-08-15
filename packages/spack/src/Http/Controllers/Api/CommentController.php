<?php

namespace Spack\Http\Controllers\Api;

use Illuminate\Http\Request;
use Spack\Models\Comment;
use Spack\Models\Task;

class CommentController
{
    /**
     * Display a listing of the comment.
     */
    public function index(Task $task)
    {
        $comments = $task->comments;

        return $comments;
    }

    /**
     * Show the form for creating a new comment.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created comment in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|integer',
            'text' => 'required|string|min:2',
        ]);

        $comments = Comment::create([
            'user_id' => auth()->id(),
            'task_id' => $request->task_id,
            'text' => $request->text,
        ]);

        return [
            'message' => 'Comment created successfully',
            'model' => $comments,
        ];
    }

    /**
     * Display the specified comment.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified comment.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified comment in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'text' => 'required|string|max:100|min:2',
        ]);

        $comment->update([
            'text' => $request->text,
        ]);

        return [
            'message' => 'Comment updated successfully',
            'model' => $comment,
        ];
    }

    /**
     * Remove the specified comment from storage.
     */
    public function delete(Comment $comment)
    {
        $comment->delete();

        return ['message' => 'Comment deleted successfully!'];
    }
}

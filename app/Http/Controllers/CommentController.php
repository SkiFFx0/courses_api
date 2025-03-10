<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Submission;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    private function getCommentableClass($type)
    {
        return match ($type) {
            'course' => Course::class,
            'submission' => Submission::class,
            default => null,
        };
    }

    public function store(Request $request, $commentableType, $commentableId)
    {
        $request->validate([
            'content' => ["required", "string"],
        ]);

        $commentableClass = $this->getCommentableClass($commentableType);

        $commentable = $commentableClass::find($commentableId);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $commentable->comments()->save($comment);

        $commentable->comments()->save($comment);

        return response()->json([
            'message' => 'Comment added successfully', 'comment' => $comment
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => ["required", "string"],
        ]);

        $comment->update(['content' => $request->input('content')]);

        return response()->json([
            'message' => 'Comment updated successfully', 'comment' => $comment
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json([
            'message' => 'Comment deleted successfully'
        ]);
    }
}

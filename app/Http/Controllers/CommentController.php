<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\storeRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Models\ApiResponse;
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

    public function store(StoreRequest $request, $commentableType, $commentableId)
    {
        $request->validated();

        $commentableClass = $this->getCommentableClass($commentableType);

        $commentable = $commentableClass::find($commentableId);

        $comment = new Comment();
        $comment->user_id = auth()->id();
        $comment->content = $request->input('content');
        $commentable->comments()->save($comment);

        $commentable->comments()->save($comment);

        return ApiResponse::success('Comment added successfully', [
            'comment' => $comment,
            'commentable' => $commentable,
        ]);
    }

    public function update(UpdateRequest $request, Comment $comment)
    {
        $request->validated();

        $comment->update(['content' => $request->input('content')]);

        return ApiResponse::success('Comment updated successfully', [
            'comment' => $comment,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return ApiResponse::success('Comment deleted successfully');
    }
}

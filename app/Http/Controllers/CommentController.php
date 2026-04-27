<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CommentService $commentService) {}

    public function index(string $id)
    {
        $comments = $this->commentService->index($id);

        return CommentResource::collection($comments);
    }

    public function store(StoreCommentRequest $request, string $id)
    {
        $comment = $this->commentService->store(
            $id,
            auth()->id(),
            $request->validated('body')
        );

        return new CommentResource($comment);
    }

    public function destroy(string $id)
    {
        $comment = Comment::findOrFail($id);

        $this->authorize('delete', $comment);

        $this->commentService->destroy($id);

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}

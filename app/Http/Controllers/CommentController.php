<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        // Get all comments with information about user and product, sorted by date
        $comments = Comment::with('user', 'product')
        ->latest()
        ->paginate(10);


        return CommentResource::collection($comments);
    }

    public function store(CommentRequest $request, Product $product)
    {
        $comment = $product->comments()->create([
            'user_id' => auth()->id(),
            'comment' => $request->input('comment'),
        ]);
        return new CommentResource($comment);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id === auth()->id()) {
            $comment->delete();
            return response()->noContent();
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}

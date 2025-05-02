<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class CommentController extends Controller
{

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

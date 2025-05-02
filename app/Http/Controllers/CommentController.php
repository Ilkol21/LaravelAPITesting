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
        // Получаем все комментарии с информацией о пользователе и продукте, отсортированные по дате
        $comments = Comment::with('user', 'product')  // Загрузка связанных моделей
        ->latest()  // Сортировка по дате (сначала новые)
        ->paginate(10);  // Пагинация

        // Возвращаем данные в виде ресурса
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

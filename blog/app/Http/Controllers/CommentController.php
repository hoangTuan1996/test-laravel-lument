<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CommentController extends Controller
{


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'post_id' => 'required|numeric|exists:users,id',
            'content' => 'required|string',
        ]);

        try {
            Comment::create([
                'post_id' => $request->get('post_id'),
                'content' => $request->get('content'),
                'user_id' => $request->get('user_id'),
                'comment_id' => $request->get('comment_id')
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

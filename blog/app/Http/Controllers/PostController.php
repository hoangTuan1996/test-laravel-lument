<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $posts = Post::when($request->get('search'), function ($query) use ($request) {
            $query->where('title', 'like', '%' . $request->get('search'). '%');
        })->get();

        return response()->json($posts);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string',
            'description' => 'required|string'
        ]);



        try {
            Post::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'description' => $request->get('description'),
                'user_id' => \auth()->user()->id,
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|string
     */
    public function update(Request $request, $id)
    {
        $user = \auth()->user();

        $post = Post::where('user_id', $user->id)->find($id);

        if (!$post && $user->permission == 'admin') {
            return response()->json(['message' => 'User not permission update post'], 403);
        }

        $data = $request->only('title', 'content', 'description', 'user_id');

        try {
            $post->fill($data);
            $post->save();

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}

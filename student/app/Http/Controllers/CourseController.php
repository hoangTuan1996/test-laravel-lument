<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Post;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
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
        $course = Course::when($request->get('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->get('search'). '%');
        })->get();

        return response()->json($course);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
        ]);

        try {
            Course::create([
                'name' => $request->get('name'),
                'user_id' => \auth()->user()->id,
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function createPost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            Post::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'user_id' => \auth()->user()->id,
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete($id)
    {
        $user = \auth()->user();

        if ($user->permission != 'admin') {
            return response()->json(['message' => 'User permission'], 403);
        }
    }
}

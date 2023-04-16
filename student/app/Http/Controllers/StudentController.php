<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\Post;
use App\Models\Student;
use App\Models\StudentCourse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function studentSignCourse(Request $request)
    {
        $this->validate($request, [
            'course_id' => 'required|string',
        ]);

        try {
            StudentCourse::create([
                'course_id' => $request->get('course_id'),
                'student_id' => \auth()->user()->id
            ]);

            return response()->json([
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getPost(Request $request)
    {
        $user = \auth()->user();
        return response()->json(
            Post::where('course_id', $user->course->id)->get()
        );
    }

    public function getDetailPost($postId)
    {
        $user = \auth()->user();
        return response()->json(
            Post::where('id', $postId)->where('course_id', $user->course->id)->first()
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse|string
     * @throws ValidationException
     */
    public function createComment(Request $request)
    {
        $this->validate($request, [
            'post_id' => 'required|string',
            'content' => 'required|string',
        ]);

        try {
            Comment::create([
                'post_id' => $request->get('post_id'),
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

    public function deleteComment($id)
    {
        Comment::find($id)->delete();

        return response()->json([
            'status' => 200
        ]);
    }
}

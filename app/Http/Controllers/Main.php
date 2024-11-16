<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Models\Que;
use App\Models\User;
use Illuminate\Http\Request;

class Main extends Controller
{
    //

    public function index($user_id)
    {
        // dd('Welcome to student forum');

        $user = User::find(id: $user_id);
        $ques = Que::select('ques.*', 'users.*')->leftJoin('users', 'ques.user_id', '=', 'users.id')->get();

        // dd($ques);

        return view('forum', ['user' => $user, 'ques' => $ques]);
    }

    public function add_question($user_id, Request $req)
    {
        // Validate the request input
        $req->validate([
            'question' => 'required|string|max:255',
        ]);

        // Find the user
        $user = User::find($user_id);

        // Check if the user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Create a new question entry
        $question = new Que();
        $question->user_id = $user_id;
        $question->question = $req->input('question');
        $question->comments = 0;
        $question->likes = 0;

        // Save the question
        $question->save();

        // Redirect to the student forum route
        return redirect()->route('student-forum', ['user_id' => $user_id])
            ->with('success', 'Your question has been submitted.');
    }

    public function add_like($user_id, $post_id, Request $req)
    {

        // Find the user
        $user = User::find($user_id);
        $post = Que::find($post_id);

        // Check if the user exists
        if (!$user || !$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'User or post not found.',
            ], 404);
        }

        $like = new like();

        $like->user_id = $user_id;
        $like->post_id = $post_id;
        $like->is_liked = $req->get('is_liked');
        $like->like_type = $req->get('like_type');

        $like->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Post liked successfully.',
            'likes' => $post->likes + 1, // Assuming you store like count in the `Que` model
        ]);
    }

}

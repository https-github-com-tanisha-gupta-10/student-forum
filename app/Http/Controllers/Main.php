<?php

namespace App\Http\Controllers;

use App\Models\Like;
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

    public function add_like(Request $req)
    {

        return response()->json("hello", 200, );
        // $req->validate([
        //     'user_id' => 'required',
        //     'post_id' => 'required',
        // ]);

        // $existingLike = Like::where('user_id', $req->user_id)->where('post_id', $req->post_id)->where('is_liked', 1)->first();

        // if ($existingLike) {
        //     if ($existingLike->is_liked) {
        //         $existingLike->is_liked = 0;
        //         $existingLike->like_type = 'dislike';
        //     } else {
        //         $existingLike->is_liked = 1;
        //         $existingLike->like_type = $req->like_type;
        //     }

        //     $existingLike->save();

        // } else {

        //     $like = new Like();

        //     $like->user_id = $req->get('user_id');
        //     $like->post_id = $req->get('post_id');
        //     $like->is_liked = $req->get('is_liked');
        //     $like->like_type = $req->get('like_type');

        //     $like->save();
        // }

        // return response()->json([
        //     'code' => 200,
        //     'message' => 'Like added successfully.',
        // ], 200, );
    }

}

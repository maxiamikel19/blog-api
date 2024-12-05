<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return Comment::all();
        return new CommentCollection(Comment::with('user')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth::user()->id;
        $payload = $request->validate([
            "comment"=> "required",
            "post_id" => "required|exists:posts,id"
        ]);
        $payload["user_id"] = $user_id;
        $comment = Comment::create($payload);

        return [
            "comment" => $comment,
            "user" => $request->user()
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return [
            "comment" => $comment,
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        Gate::authorize('modify', $comment);
        $comment->delete();
    }
}

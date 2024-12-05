<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostCollection;
use App\Models\Post;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET
     * http://localhost:8000/api/posts
     */
    public function index()
    {
        return new PostCollection(Post::orderBy("id", "desc")->get());
    }

    /**
     * Store a newly created resource in storage.
     * POST
     * http://localhost:8000/api/posts
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            "title" => "required|max:255",
            "content"=> "required",
        ]);
        $post = $request->user()->posts()->create($payload);
        return ([
            "post" => $post,
            "user" => $post->user
        ]);
    }

    /**
     * Display the specified resource.
     * GET
     * http://localhost:8000/api/posts/1
     */
    public function show( $id){
        //return $post = Post::with(['user', 'comments'])->findOrFail($id);
        return $post = Post::with(['user','comments.user'])->findOrFail($id);

        // return ['post' => $post];
    }

    public function getUserPosts(){
        $user = auth::user();
        $posts = $user->posts;

        if(sizeof($posts) > 0){
            return [
                "posts" => $posts
            ];
        }
        return [
            "message" => "You dont have any owm post"
        ];
    }

    /**
     * Update the specified resource in storage.
     * PUT
     * http://localhost:8000/api/posts/1
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize("modify", $post);
        $payload = $request->validate([
            "title" => "required|max:255",
            "content"=> "required"
            ]);
            $post->update($payload);
            return ([
                "post" => $post
            ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE
     * http://localhost:8000/api/posts/1
     */
    public function destroy(Post $post)
    {
        Gate::authorize("modify", $post);
        $post->delete();
        return ([
            "message" => "Deleted successfully"
        ]);
    }
}

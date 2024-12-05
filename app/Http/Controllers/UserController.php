<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id){
        $user = User::where("id",$id)->withcount("comments")->withcount("posts")->first();
        return ["user" => $user];
    }
}

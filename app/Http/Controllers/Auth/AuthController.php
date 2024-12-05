<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $payload = $request->validate([
            "name" => "required|max:120|min:3",
            "email"=> "required|email|unique:users",
            "password"=> "required|confirmed|min:4|max:10",
        ]);

        $payload["password"] = Hash::make($payload["password"]);
        $user = User::create($payload);
        $token = $user->createToken($request->name)->plainTextToken;

        return response()->json([
            "user" => $user,
            "token" => $token
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            "email"=> "required|exists:users",
            "password"=> "required"
        ]);

        $user = User::where("email", $credentials["email"])->first();
        if(!$user || !Hash::check($credentials["password"], $user->password)){
            return [
                "errors" => [
                    "email"=> "User email or password incorrect"
                ]
            ];
        }
        $token = $user->createToken($user->name)->plainTextToken;
        return Response()->json([
            "user" => $user,
            "token" => $token
        ], 422);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();

        return ["message"=> "Logged out successfully"];
    }
}

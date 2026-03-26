<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Simulating a token for now since Sanctum is not installed
        // In a real app, you'd use $user->createToken('flutter-app')->plainTextToken;
        $token = base64_encode($user->email . '|' . now()->toDateTimeString());

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function user(Request $request)
    {
        // For now, since we don't have Sanctum, we'll just return the user if they are logged in via session
        // or if we implement a custom guard. 
        // For simplicity in this "direct" fix, we'll return auth user.
        return response()->json(auth()->user());
    }
}

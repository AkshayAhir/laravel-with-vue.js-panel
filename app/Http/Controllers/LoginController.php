<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Invalid input'], 400);
        }

        $user = Test::where('email', $request->email)->first();

        if ($user && $request->password === $user->password) {
            // Authentication passed
            return response()->json(['message' => 'Login successful']);
        }

        return response()->json(['message' => 'Login failed'], 401);
    }
}

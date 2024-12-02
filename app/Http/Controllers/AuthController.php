<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
        ], 201);
    }
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'],
        $user->password))
        {
            return response()->json([
                'message' => 'Invalid credentials'],401);
        }

        // Create token
        $token = $user->createToken('authToken')->accessToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'token' => $token,
        ], 200);
    }
}


<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            //check if user is disabled before registration
            $existingUser = User::where('email', $request->email)
                ->orWhere('phone_number', $request->phone_number)
                ->first();
            if ($existingUser && (!$existingUser->is_active || $existingUser->is_deleted)) {
                return response()->json(['message' => 'Your account is disabled. Please contact support.'], 403);
            }

            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:15|unique:users',
                'type' => 'required|string|in:customer,driver',
                'password' => 'required|string|min:8|confirmed',
                'profile_photo_path' => 'nullable|string|max:255',
                'is_verified' => 'boolean',
                'is_active' => 'boolean',
                'is_deleted' => 'boolean',
                'email_verified_at' => 'nullable|date',
            ]);
            $data['password'] = Hash::make($data['password']);
            DB::beginTransaction();
            $user = User::create($data);
            $token = $user->createToken('api-token')->plainTextToken;
            DB::commit();
            return response()->json([
                'message' => 'User registered successfully',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Registration failed', 'error' => $e->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        // check if user is disabled before login
        $existingUser = User::where('email', $request->email)
            ->orWhere('phone_number', $request->phone_number)
            ->first();
        if (!$existingUser || !$existingUser->is_active || $existingUser->is_deleted) {
            return response()->json(['message' => 'Your account is disabled. Please contact support.'], 403);
        }
        // Allow login with either email or phone number
        $request->validate([
            'email' => 'nullable|email|required_without:phone_number|exists:users,email',
            'phone_number' => 'nullable|string|required_without:email|exists:users,phone_number',
            'password' => 'required|string',
        ]);

        $login = $request->email ?? $request->phone_number;

        $user = User::where('email', $login)
            ->orWhere('phone_number', $login)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken($user->name)->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}

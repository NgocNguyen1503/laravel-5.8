<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    function login(Request $request)
    {
        try {
            return ApiResponse::success("login");
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return ApiResponse::internalServerError([
                'error' => $th->getMessage()
            ]);
        }
    }

    function signup(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email'],
                'password' => ['required', 'min:8', 'confirmed'],
                'password_confirmation' => ['required']
            ]);

            if (User::where('email', $validated['email'])->first() != null) {
                return ApiResponse::forbidden("This email is already associated with an account");
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password'])
            ]);

            return ApiResponse::success(compact('user'));
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();

            return ApiResponse::success([
                'users' => $users
            ]);
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function store(Request $request)
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
            Log::error($th->getMessage());

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function show(string $id)
    {
        try {
            $user = User::find($id);

            return ApiResponse::success([
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $params = $request->all();

            $user = Auth::user();
            $user->forceFill([
                'name' => $params['name'] ?? $user->name,
                'email' => $params['email'] ?? $user->email,
            ])->save();

            return ApiResponse::success([
                'user' => $user
            ]);
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            User::destroy($id);

            return ApiResponse::success();
        } catch (\Throwable $th) {
            Log::error($th);

            return ApiResponse::internalServerError($th->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::all();

            return ApiResponse::success(compact("users"));
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return ApiResponse::internalServerError($th->getMessage());
        }
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

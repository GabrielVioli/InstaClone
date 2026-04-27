<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidateRequest;
use App\Http\Requests\LoginValidateRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function Login(LoginValidateRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => (new UserResource($user))->resolve()
        ]);
    }

    public function register(AuthValidateRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => (new UserResource($user))->resolve()
        ]);
    }

    public function Logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json([
            'message' => 'Logout realizado com sucesso. Token revogado.'
        ], 200);
    }


    public function Me(Request $request)
    {
        return (new UserResource($request->user()));
    }

}

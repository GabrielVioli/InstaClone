<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthValidateRequest;
use App\Http\Requests\LoginValidateRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller {
    public function __construct(private AuthService $auth) {

    }

    public function login(LoginValidateRequest $request)
    {
        $user = $this->auth->login($request->validated());

        return $this->respondWithToken($user);
    }

    public function register(AuthValidateRequest $request)
    {
        $user = $this->auth->register($request->validated());

        return $this->respondWithToken($user);
    }

    public function logout(Request $request)
    {
        $this->auth->logout($request->user());

        return response()->json([
            'message' => 'Logout realizado com sucesso. Token revogado.'
        ], 200);
    }

    public function me(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Método privado para evitar repetição no Login e Register.
     */
    private function respondWithToken(User $user)
    {
        $token = $this->auth->createToken($user);

        return response()->json([
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => (new UserResource($user))->resolve()
        ]);
    }
}

<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\API\Controller;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Autenticação"},
     *     summary="Realiza o login do usuário",
     *     operationId="login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/LoginRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login realizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/TokenResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     tags={"Autenticação"},
     *     summary="Retorna o usuário autenticado",
     *     operationId="me",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário autenticado retornado com sucesso"
     *     )
     * )
     */
    public function me()
    {
        return response()->json(auth()->user()->load('customer'));
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     tags={"Autenticação"},
     *     summary="Realiza o logout do usuário",
     *     operationId="logout",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Logout feito com sucesso"
     *     )
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Logout feito com sucesso']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     tags={"Autenticação"},
     *     summary="Atualiza o token JWT",
     *     operationId="refresh",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Token atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/TokenResponse")
     *     )
     * )
     */
    public function refresh()
    {
        return response()->json([
            'access_token' => auth()->refresh(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}

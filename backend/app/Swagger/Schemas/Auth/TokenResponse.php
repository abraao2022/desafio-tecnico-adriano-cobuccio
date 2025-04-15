<?php

namespace App\Swagger\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="TokenResponse",
 *     title="TokenResponse",
 *     @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLC..."),
 *     @OA\Property(property="token_type", type="string", example="bearer"),
 *     @OA\Property(property="expires_in", type="integer", example=3600),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="João da Silva"),
 *         @OA\Property(property="email", type="string", example="joao@email.com")
 *     )
 * )
 */
class TokenResponse {}

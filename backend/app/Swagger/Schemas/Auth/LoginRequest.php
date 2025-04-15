<?php

namespace App\Swagger\Schemas\Auth;

/**
 * @OA\Schema(
 *     schema="LoginRequest",
 *     title="LoginRequest",
 *     required={"email", "password"},
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="usuario@email.com"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         format="password",
 *         example="123456"
 *     )
 * )
 */
class LoginRequest {}

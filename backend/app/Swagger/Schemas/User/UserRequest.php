<?php

namespace App\Swagger\Schemas\User;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     type="object",
 *     required={"name", "email", "cpf", "password"},
 *     @OA\Property(property="name", type="string", example="Lucas"),
 *     @OA\Property(property="email", type="string", example="lucass@example.com"),
 *     @OA\Property(property="cpf", type="string", example="13345678920"),
 *     @OA\Property(property="password", type="string", example="senhasegura")
 * )
 */
class UserRequest {}

<?php

namespace App\Swagger\Schemas\Customer;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="CustomerRequest",
 *     type="object",
 *     required={"user", "customer"},
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/UserRequest"
 *     ),
 *     @OA\Property(
 *         property="customer",
 *         type="object",
 *         required={"balance"},
 *         @OA\Property(property="balance", type="number", format="float", example=100.0),
 *         @OA\Property(property="phone_number", type="string", example="11999999999")
 *     )
 * )
 */
class CustomerRequest {}

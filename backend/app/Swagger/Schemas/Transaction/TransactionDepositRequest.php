<?php

namespace App\Swagger\Schemas\Transaction;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TransactionDepositRequest",
 *     type="object",
 *     required={
 *         "from_customer_id",
 *         "to_customer_id",
 *         "amount",
 *         "description",
 *         "metadata"
 *     },
 *     @OA\Property(
 *         property="from_customer_id",
 *         type="integer",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="to_customer_id",
 *         type="integer",
 *         example=20
 *     ),
 *     @OA\Property(
 *         property="amount",
 *         type="number",
 *         format="float",
 *         example=250.75
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Transferência para outro cliente"
 *     ),
 *     @OA\Property(
 *         property="metadata",
 *         type="string",
 *         example="{}"
 *     )
 * )
 */
class TransactionDepositRequest {}

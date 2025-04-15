<?php

namespace App\Swagger\Schemas\Transaction;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="TransactionRevertRequest",
 *     type="object",
 *     required={
 *         "transaction_id"
 *     },
 *     @OA\Property(
 *         property="transaction_id",
 *         type="integer",
 *         example=10
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Transferência para outro cliente"
 *     )
 * )
 */
class TransactionRevertRequest {}

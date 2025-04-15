<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    public function toArray($request)
{
    return [
        'id' => $this->id,
        'reference' => $this->reference,
        'from_customer_id' => $this->from_customer_id,
        'to_customer_id' => $this->to_customer_id,
        'amount' => $this->amount,
        'type' => $this->type,
        'status' => $this->status,
        'description' => $this->description,
        'metadata' => $this->metadata,
    ];
}
}

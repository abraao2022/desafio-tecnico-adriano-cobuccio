<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference',
        'from_customer_id',
        'to_customer_id',
        'amount',
        'type',
        'status',
        'description',
        'metadata',
        'reversed_by_admin_id',
        'reversed_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'metadata' => 'array',
        'reversed_at' => 'datetime',
    ];

    public function from()
    {
        return $this->belongsTo(Customer::class, 'from_customer_id');
    }

    public function to()
    {
        return $this->belongsTo(Customer::class, 'to_customer_id');
    }

    public function reversedBy()
    {
        return $this->belongsTo(Admin::class, 'reversed_by_admin_id');
    }
}


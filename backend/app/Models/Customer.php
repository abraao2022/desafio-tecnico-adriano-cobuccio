<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Customer extends Model
{
    use HasFactory;
    use LogsActivity;

    protected static $logName = 'customer';

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['phone_number', 'balance'])
            ->useLogName('customer')
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Cliente foi {$eventName}");
    }

    protected $fillable = [
        'user_id',
        'balance',
        'phone_number',
        'last_transaction_at',
        'blocked',
    ];

    protected $casts = [
        'balance' => 'float',
        'blocked' => 'boolean',
        'last_transaction_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sentTransactions()
    {
        return $this->hasMany(Transaction::class, 'from_customer_id');
    }

    public function receivedTransactions()
    {
        return $this->hasMany(Transaction::class, 'to_customer_id');
    }
}


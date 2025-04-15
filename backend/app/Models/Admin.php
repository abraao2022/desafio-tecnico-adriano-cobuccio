<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reversedTransactions()
    {
        return $this->hasMany(Transaction::class, 'reversed_by_admin_id');
    }
}


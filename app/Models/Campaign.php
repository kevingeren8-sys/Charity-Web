<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Donation;

class Campaign extends Model
{
    use HasFactory;

    // Izin kolom yang boleh diisi
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'image',
        'target_amount',
        'current_amount',
        'withdrawn_amount',
        'status',
        'campaigner_fee_percentage',
        'withdrawal_status',
        'bank_name',
        'bank_account_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}

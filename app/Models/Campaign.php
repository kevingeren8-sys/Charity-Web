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
        'target_amount',
        'current_amount',
        'status',
        'campaigner_fee_percentage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}

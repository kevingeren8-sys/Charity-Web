<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // Nampilin form donasi
    public function create(Campaign $campaign)
    {
        return view('donations.create', compact('campaign'));
    }

    // Proses masukin duitnya
    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'amount' => 'required|integer|min:1000',
        ]);

        // 1. Simpen catetan donasi
        Donation::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'amount' => $request->amount,
        ]);

        // 2. Tambahin duitnya ke total dana campaign
        $campaign->increment('current_amount', $request->amount);

        // 3. Tarik data terbaru dari DB, terus cek apakah udah tembus target
        $campaign->refresh(); 
        if ($campaign->current_amount >= $campaign->target_amount) {
            // Kalau tembus, otomatis statusnya jadi completed
            $campaign->update(['status' => 'completed']);
        }

        return redirect()->route('dashboard')->with('success', 'Makasih orang baik! Donasi lu udah masuk.');
    }
}
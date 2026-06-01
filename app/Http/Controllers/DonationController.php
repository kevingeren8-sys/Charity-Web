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
        // Validasi nominal donasi (misal minimal Rp 10.000)
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $total_paid = $request->amount; 
        $app_fee = $total_paid * 0.025; 
        $campaigner_fee = $total_paid * ($campaign->campaigner_fee_percentage / 100); 
        $amount_bersih = $total_paid - $app_fee - $campaigner_fee;

        // Simpan ke database
        $donation = Donation::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'amount' => $amount_bersih, 
            'app_fee' => $app_fee,
            'campaigner_fee' => $campaigner_fee,
            'total_paid' => $total_paid, 
            'status' => 'pending',
            'snap_token' => null, 
        ]);

        return redirect()->route('donations.pay', $donation->id);
    }

    public function pay(Donation $donation)
    {
        // Pastiin cuma yang statusnya pending yang bisa diakses
        if ($donation->status !== 'pending') {
            return redirect()->route('dashboard')->with('error', 'Donasi ini sudah diproses.');
        }

        return view('donations.pay', compact('donation'));
    }

    public function confirm(Donation $donation)
    {
        // Ubah status donasi jadi paid
        $donation->update(['status' => 'paid']);

        // Tambahin uangnya ke total dana terkumpul di campaign
        $donation->campaign->increment('current_amount', $donation->amount);

        // Balikin ke dashboard dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Hore! Pembayaran berhasil dikonfirmasi. Terima kasih orang baik!');
    }

    
}
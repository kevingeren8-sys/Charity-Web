<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    // Nampilin form buat bikin campaign baru
    public function create()
    {
        if (Auth::user()->role !== 'campaigner') {
            abort(403, 'Ups! Cuma Campaigner yang boleh bikin galang dana bro.');
        }
        return view('campaigns.create');
    }

    // Nangkap data dari form dan simpen ke Database
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Kesehatan,Pendidikan,Bencana Alam,Sosial',
            'description' => 'required|string',
            'target_amount' => 'required|integer|min:1000',
            'campaigner_fee_percentage' => 'required|numeric|min:0|max:15'
        ]);

        $netTarget = $request->target_amount;
        $feeCampaigner = $request->campaigner_fee_percentage;

        $markupApp = $netTarget * 0.025;
        $markupCampaigner = $netTarget * ($feeCampaigner / 100);

        $grossTarget = $netTarget + $markupApp + $markupCampaigner;

        Campaign::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'target_amount' => $grossTarget,
            'current_amount' => 0, 
            'status' => 'pending',
            'campaigner_fee_percentage' => $feeCampaigner
        ]);

        return redirect()->route('dashboard')->with('success', 'Campaign berhasil dibuat!'); // Kalau sukses, lempar balik ke Dashboard
    }

    // Fungsi buat Admin Approve
    public function approve(Campaign $campaign)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang bisa approve!');
        }
        
        $campaign->update(['status' => 'approved']);
        return redirect()->route('dashboard')->with('success', 'Campaign berhasil di-approve!');
    }

    // Fungsi buat Admin Reject
    public function reject(Campaign $campaign)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya Admin yang bisa reject!');
        }
        
        $campaign->update(['status' => 'rejected']);
        return redirect()->route('dashboard')->with('success', 'Campaign ditolak!');
    }

    // Fungsi buat nampilin detail campaign
    public function show(Campaign $campaign)
    {
        // Ambil data donasi beserta relasi user yang berdonasi (Eager Loading)
        $donations = $campaign->donations()->with('user')->latest()->get();

        return view('campaigns.show', compact('campaign', 'donations'));
    }
}

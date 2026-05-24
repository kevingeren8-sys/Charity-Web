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
        if (Auth::user()->role !== 'campaigner') {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'target_amount' => 'required|integer|min:1000',
        ]);

        Campaign::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'target_amount' => $request->target_amount,
            'current_amount' => 0, 
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard'); // Kalau sukses, lempar balik ke Dashboard
    }
}

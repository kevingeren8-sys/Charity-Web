<?php

use App\Http\Controllers\CampaignController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Campaign;
use App\Http\Controllers\DonationController;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    if ($user->role === 'campaigner') {
        // Campaigner cuma narik data miliknya sendiri
        $campaigns = Campaign::where('user_id', $user->id)->latest()->get();
        return view('dashboard', compact('campaigns'));

    } elseif($user->role === 'admin'){
        // Admin narik data yang masih pending buat di-approve/reject
        $campaigns = Campaign::where('status', 'pending')->latest()->get();
        return view('dashboard', compact('campaigns'));

    } else {
        // Donatur cuma bisa liat campaign yang udah approved
        $campaigns = Campaign::where('status', 'approved')->latest()->get();
        return view('dashboard', compact('campaigns'));
    }

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // 1. Profile Bawaan Laravel
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Bikin Campaign (Wajib di atas karena bukan parameter dinamis)
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');

    // 3. Action Donasi & Verifikasi Admin (Pakai parameter {campaign})
    Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])->name('donations.create');
    Route::post('/campaigns/{campaign}/donate', [DonationController::class, 'store'])->name('donations.store');
    Route::patch('/campaigns/{campaign}/approve', [CampaignController::class, 'approve'])->name('campaigns.approve');
    Route::patch('/campaigns/{campaign}/reject', [CampaignController::class, 'reject'])->name('campaigns.reject');

    // 4. Nampilin Detail / Riwayat Campaign (Wajib di paling bawah grup)
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->name('campaigns.show');
});


require __DIR__.'/auth.php';

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
        // 1. Validasi Input dari form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|in:Kesehatan,Pendidikan,Bencana Alam,Sosial',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'target_amount' => 'required|integer|min:1000',
            'campaigner_fee_percentage' => 'required|numeric|min:0|max:15'
        ]);

        // 2. LOGIKA HITUNG GROSS TARGET (Ini yang sempet ilang tdi, wir)
        $netTarget = $request->target_amount; 
        $platformFee = 2.5; // Fee operational web lu (2.5%)
        $campaignerFee = $request->campaigner_fee_percentage; // Fee yang diisi di form
        $totalFeePercentage = $platformFee + $campaignerFee;

        // Rumus Gross-Up: Target Asli * (1 + Total Persen Fee / 100)
        // Misal input 100jt, fee 2.5% + 5% = 7.5%. Hasilnya otomatis jadi 107.500.000
        $grossTarget = $netTarget * (1 + ($totalFeePercentage / 100));

        // 3. Masukin data otomatis ke array
        $validatedData['user_id'] = Auth::id();
        $validatedData['target_amount'] = $grossTarget; // <-- Di sini kita TIMPA target_amount pake yang udah dapet markup fee!
        $validatedData['current_amount'] = 0;
        $validatedData['status'] = 'pending';

        // 4. Handle Upload File Foto
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('campaign_images', 'public');
        }

        // 5. Eksekusi masukin ke Database
        Campaign::create($validatedData);

        return redirect()->route('dashboard')->with('success', 'Campaign berhasil dibuat dengan penyesuaian target biaya!');
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

    public function withdraw(Request $request, Campaign $campaign)
    {
        // 1. Validasi kepemilikan
        if (Auth::id() != $campaign->user_id) {
            abort(403, 'Akses ditolak.');
        }

        // 2. Validasi input nominal penarikan (misal minimal tarik Rp 10.000)
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        $tarikDana = $request->amount;
        
        // 3. Hitung Sisa Saldo (Dana Terkumpul - Dana yang Pernah Ditarik)
        $saldoTersedia = $campaign->current_amount - $campaign->withdrawn_amount;

        // 4. Cek apakah nominal yang dimasukin masuk akal
        if ($tarikDana > $saldoTersedia) {
            return back()->with('error', 'Gagal! Nominal penarikan melebihi saldo yang tersedia (Saldo: Rp ' . number_format($saldoTersedia, 0, ',', '.') . ').');
        }

        // 5. Langsung potong saldonya (tambahin ke history penarikan)
        $campaign->increment('withdrawn_amount', $tarikDana);

        // Kalau ditarik habis semua, bisa sekalian otomatisin statusnya 
        if ($campaign->current_amount == $campaign->withdrawn_amount) {
            $campaign->update(['status' => 'completed']);
        }

        return back()->with('success', 'Berhasil! Dana sebesar Rp ' . number_format($tarikDana, 0, ',', '.') . ' langsung dicairkan ke rekening kamu.');
    }

    public function withdrawForm(Campaign $campaign)
    {
        if (Auth::id() != $campaign->user_id) {
            abort(403, 'Akses ditolak.');
        }

        // Hitung saldo yang beneran bisa ditarik
        $saldoTersedia = $campaign->current_amount - $campaign->withdrawn_amount;

        return view('campaigns.withdraw', compact('campaign', 'saldoTersedia'));
    }

    // Contoh nama fungsinya, sesuaikan sama kodingan lu
    public function processWithdraw(Request $request, Campaign $campaign)
    {
        // 1. Validasi inputan form
        $request->validate([
            'bank_name' => 'required|string',
            'bank_account_number' => 'required|numeric', // Pake numeric biar ga diisi huruf
        ]);

        // 2. Simpan data bank & ubah status withdraw (misal jadi 'pending_withdrawal')
        $campaign->update([
            'bank_name' => $request->bank_name,
            'bank_account_number' => $request->bank_account_number,
            'withdrawal_status' => 'pending', // Sesuaikan sama nama kolom status lu
        ]);

        // 3. Lempar balik dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Permintaan penarikan dana berhasil dikirim! Silakan tunggu verifikasi admin.');
    }
}

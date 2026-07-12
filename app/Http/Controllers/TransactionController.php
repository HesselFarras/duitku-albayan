<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Filter tipe transaksi (income/expense)
        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }
        
        // Filter kategori transaksi
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter Kantong Kas (Cash/Bank)
        if ($request->filled('wallet_id')) {
            $query->where('wallet_id', $request->wallet_id);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        
        // --- BALIKIN VARIABEL FILTER BAWAAN BLADE LU BULAT-BULAT ---
        $categories = Category::all();
        $wallets = Wallet::all(); 
        $incomeCategories = Category::whereIn('type', ['income', 'INCOME'])->pluck('name');
        $expenseCategories = Category::whereIn('type', ['expense', 'EXPENSE'])->pluck('name');
        // -----------------------------------------------------------

        return view('transactions.index', compact(
            'transactions', 
            'categories', 
            'wallets', 
            'incomeCategories', 
            'expenseCategories'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:0',
            'category'    => 'required|string', // Sesuai select name="category" di index
            'wallet_id'   => 'required|exists:wallets,id', // Sesuai select name="wallet_id"
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $type = strtolower($validated['type']);
        $badge = ($type === 'income') ? 'VERIFIED' : 'SPENDING';

        // 2. Petakan dan simpan ke Supabase
        $transaction = new Transaction();
        $transaction->title       = $validated['title'];
        $transaction->type        = $type;
        $transaction->amount      = $validated['amount'];
        $transaction->category    = $validated['category']; // Simpan string kategorinya
        $transaction->wallet_id   = $validated['wallet_id']; 
        $transaction->date        = $validated['date'];
        $transaction->description = $request->description ?? '-';
        $transaction->badge       = $badge;
        $transaction->user_id     = auth()->id() ?? 1;
        $transaction->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    // --- TAMBAHAN: FUNGSI EDIT YANG TADI HILANG ---
    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $wallets = Wallet::all(); 
        
        $incomeCategories = Category::whereIn('type', ['income', 'INCOME'])->pluck('name');
        $expenseCategories = Category::whereIn('type', ['expense', 'EXPENSE'])->pluck('name');
        
        return view('transactions.edit', compact('transaction', 'wallets', 'incomeCategories', 'expenseCategories'));
    }

    public function update(Request $request, $id)
    {
        // Validasi disesuaikan dengan input form edit.blade.php
        $request->validate([
            'title'       => 'required|string|max:255',
            'wallet_id'   => 'required|exists:wallets,id',
            'category'    => 'required|string', // Menggunakan category string sesuai form edit
            'amount'      => 'required|numeric|min:0',
            'date'        => 'required|date',
            'type'        => 'required|in:income,expense,INCOME,EXPENSE',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        
        $type = strtolower($request->type);
        $badge = ($type === 'income') ? 'VERIFIED' : 'SPENDING';

        $transaction->update([
            'wallet_id'   => $request->wallet_id,
            'category'    => $request->category,
            'title'       => $request->title,
            'amount'      => $request->amount,
            'date'        => $request->date,
            'type'        => $type,
            'badge'       => $badge,
            'description' => $request->description ?? '-',
        ]);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    public function laporan(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);
        $selectedWallet = $request->get('wallet_id', 'all');

        $query = Transaction::whereMonth('date', $bulan)->whereYear('date', $tahun);

        if ($selectedWallet !== 'all') {
            $query->where('wallet_id', $selectedWallet);
        }

        $transactions = $query->orderBy('date', 'asc')->get();

        $totalMasuk = $transactions->where('type', 'income')->sum('amount');
        $totalKeluar = $transactions->where('type', 'expense')->sum('amount');

        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        
        $queryAwalMasuk = Transaction::where('type', 'income')->where('date', '<', $startOfMonth);
        $queryAwalKeluar = Transaction::where('type', 'expense')->where('date', '<', $startOfMonth);

        if ($selectedWallet !== 'all') {
            $queryAwalMasuk->where('wallet_id', $selectedWallet);
            $queryAwalKeluar->where('wallet_id', $selectedWallet);
        }

        $saldoAwalMasuk = $queryAwalMasuk->sum('amount');
        $saldoAwalKeluar = $queryAwalKeluar->sum('amount');
        
        $saldoAwal = $saldoAwalMasuk - $saldoAwalKeluar;
        $saldoAkhir = $saldoAwal + $totalMasuk - $totalKeluar;
        
        $wallets = Wallet::all();

        return view('reports.index', compact(
            'transactions', 'totalMasuk', 'totalKeluar', 
            'saldoAwal', 'saldoAkhir', 'bulan', 'tahun', 'wallets', 'selectedWallet'
        ));
    }

    // --- FITUR MUTASI INTERNAL KAS (OPSI 3) ---

    /**
     * Menampilkan Form Mutasi Internal Kas
     */
    public function mutasiCreate()
    {
        $wallets = Wallet::all();
        return view('transactions.mutasi', compact('wallets'));
    }

    /**
     * Menyimpan Data Mutasi Kas (Setor/Tarik Tunai) ke Supabase
     */
    public function mutasiStore(Request $request)
    {
        $request->validate([
            'from_wallet_id' => 'required|exists:wallets,id|different:to_wallet_id',
            'to_wallet_id'   => 'required|exists:wallets,id',
            'amount'         => 'required|numeric|min:1',
            'date'           => 'required|date',
            'description'    => 'nullable|string',
        ]);

        $fromWallet = Wallet::find($request->from_wallet_id);
        $toWallet = Wallet::find($request->to_wallet_id);
        
        $nominal = $request->amount;
        $tanggal = $request->date;
        $catatanUser = $request->description ? ' (' . $request->description . ')' : '';

        // Gunakan DB Transaction agar kedua data wajib masuk bersamaan (Anti-Gagal)
        DB::transaction(function () use ($fromWallet, $toWallet, $nominal, $tanggal, $catatanUser) {
            
            // 1. Catat sisi KELUAR dari Kantong Asal
            $trxOut = new Transaction();
            $trxOut->title       = "Mutasi Keluar ke " . $toWallet->name;
            $trxOut->type        = 'expense';
            $trxOut->amount      = $nominal;
            $trxOut->category    = 'Mutasi Kas';
            $trxOut->wallet_id   = $fromWallet->id;
            $trxOut->date        = $tanggal;
            $trxOut->description = "Perpindahan dana internal dari " . $fromWallet->name . " ke " . $toWallet->name . $catatanUser;
            $trxOut->badge       = 'MUTASI';
            $trxOut->user_id     = auth()->id() ?? 1;
            $trxOut->save();

            // 2. Catat sisi MASUK ke Kantong Tujuan
            $trxIn = new Transaction();
            $trxIn->title       = "Mutasi Masuk dari " . $fromWallet->name;
            $trxIn->type        = 'income';
            $trxIn->amount      = $nominal;
            $trxIn->category    = 'Mutasi Kas';
            $trxIn->wallet_id   = $toWallet->id;
            $trxIn->date        = $tanggal;
            $trxIn->description = "Perpindahan dana internal dari " . $fromWallet->name . " ke " . $toWallet->name . $catatanUser;
            $trxIn->badge       = 'MUTASI';
            $trxIn->user_id     = auth()->id() ?? 1;
            $trxIn->save();
        });

        return redirect()->route('transaksi.index')->with('success', 'Mutasi internal kas berhasil diproses!');
    }
}

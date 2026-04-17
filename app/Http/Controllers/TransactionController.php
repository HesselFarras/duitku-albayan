<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        // Jalankan filter jika ada request dari tombol
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $transactions = $query->orderBy('date', 'desc')->get();

        // BAGIAN PENTING: Ambil kategori unik untuk tombol filter
        // Ini supaya variabel $incomeCategories dan $expenseCategories terdefinisi
        $incomeCategories = Transaction::where('type', 'income')->distinct()->pluck('category');
        $expenseCategories = Transaction::where('type', 'expense')->distinct()->pluck('category');

        // Kirim semua variabel ke view
        return view('transactions.index', compact(
            'transactions', 
            'incomeCategories', 
            'expenseCategories'
        ));
    }

    public function store(Request $request)
    {
        $validated = $this->validateRequest($request);

        // Tambahkan user_id & badge otomatis
        $validated['user_id'] = Auth::id() ?? 1; 
        $validated['badge'] = ($request->type == 'income') ? 'VERIFIED' : 'SPENDING';

        Transaction::create($validated);

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi data
        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'category' => 'required',
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
        ]);

        // 2. Cari datanya
        $transaction = Transaction::findOrFail($id);

        // 3. Update datanya
        $transaction->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => $request->date,
            'type' => $request->type,
        ]);

        // 4. Redirect kembali ke halaman index dengan pesan sukses
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        // GANTI BAGIAN INI:
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
    }

    /**
     * Helper untuk validasi agar tidak nulis berulang-ulang
     */
    private function validateRequest(Request $request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);
    }
}
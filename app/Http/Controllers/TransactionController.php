<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('type')) {
            $query->where('type', strtolower($request->type));
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $transactions = $query->orderBy('date', 'desc')->get();
        $incomeCategories = Category::whereIn('type', ['income', 'INCOME'])->pluck('name');
        $expenseCategories = Category::whereIn('type', ['expense', 'EXPENSE'])->pluck('name');

        return view('transactions.index', compact('transactions', 'incomeCategories', 'expenseCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:income,expense,INCOME,EXPENSE',
            'amount'      => 'required|numeric|min:0',
            'category'    => 'required|string',
            'date'        => 'required|date',
            'description' => 'nullable|string',
        ]);

        $type = strtolower($validated['type']);
        $badge = ($type === 'income') ? 'VERIFIED' : 'SPENDING';

        $transaction = new Transaction();
        $transaction->title       = $validated['title'];
        $transaction->type        = $type;
        $transaction->amount      = $validated['amount'];
        $transaction->category    = $validated['category'];
        $transaction->date        = $validated['date'];
        $transaction->description = $validated['description'] ?? '-';
        $transaction->badge       = $badge;
        $transaction->user_id     = Auth::id() ?? 1;
        $transaction->save();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'amount'      => 'required|numeric|min:0',
            'category'    => 'required|string',
            'date'        => 'required|date',
            'type'        => 'required|in:income,expense,INCOME,EXPENSE',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::findOrFail($id);
        
        // Gunakan lowercase
        $type = strtolower($request->type);
        $badge = ($type === 'income') ? 'VERIFIED' : 'SPENDING';

        $transaction->update([
            'title'       => $request->title,
            'amount'      => $request->amount,
            'category'    => $request->category,
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

        $transactions = Transaction::whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->orderBy('date', 'asc')
            ->get();

        // Gunakan lowercase untuk filter laporan
        $totalMasuk = $transactions->where('type', 'income')->sum('amount');
        $totalKeluar = $transactions->where('type', 'expense')->sum('amount');

        $startOfMonth = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth()->toDateString();
        $saldoAwalMasuk = Transaction::where('type', 'income')->where('date', '<', $startOfMonth)->sum('amount');
        $saldoAwalKeluar = Transaction::where('type', 'expense')->where('date', '<', $startOfMonth)->sum('amount');
        
        $saldoAwal = $saldoAwalMasuk - $saldoAwalKeluar;
        $saldoAkhir = $saldoAwal + $totalMasuk - $totalKeluar;

        return view('reports.index', compact(
            'transactions', 'totalMasuk', 'totalKeluar', 
            'saldoAwal', 'saldoAkhir', 'bulan', 'tahun'
        ));
    }
}
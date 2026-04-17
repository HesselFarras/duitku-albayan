<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data saldo
        $totalPemasukan = Transaction::where('type', 'income')->sum('amount') ?: 0;
        $totalPengeluaran = Transaction::where('type', 'expense')->sum('amount') ?: 0;
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $surplus = $totalSaldo;

        // 2. LOGIKA CHART (6 Bulan Terakhir)
        $tempData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::now()->subMonths($i);
            $start = $date->copy()->startOfMonth()->toDateString();
            $end = $date->copy()->endOfMonth()->toDateString();

            $income = Transaction::where('type', 'income')->whereBetween('date', [$start, $end])->sum('amount') ?: 0;
            $expense = Transaction::where('type', 'expense')->whereBetween('date', [$start, $end])->sum('amount') ?: 0;

            $tempData[] = [
                'bulan' => $date->translatedFormat('M'),
                'income_raw' => (float)$income,
                'expense_raw' => (float)$expense,
            ];
        }

        // CARI MAX VALUE DARI DATA YANG ADA SAJA
        // Jangan pakai default 1 juta, pakai angka terbesar dari transaksi yang ada
        $maxInTemp = collect($tempData)->flatMap(fn($item) => [$item['income_raw'], $item['expense_raw']])->max();
        $limitMax = $maxInTemp > 0 ? $maxInTemp : 1; // Jika semua nol, bagi 1

        $chartData = [];
        foreach ($tempData as $data) {
            // Hitung persentase
            $pemasukanHeight = ($data['income_raw'] / $limitMax) * 100;
            $pengeluaranHeight = ($data['expense_raw'] / $limitMax) * 100;

            $chartData[] = [
                'bulan' => $data['bulan'],
                // Jika ada uangnya, minimal kasih tinggi 10% supaya kelihatan batangnya
                'masuk' => $data['income_raw'] > 0 ? max($pemasukanHeight, 10) : 0,
                'keluar' => $data['expense_raw'] > 0 ? max($pengeluaranHeight, 10) : 0,
            ];
        }

        $recentTransactions = Transaction::orderBy('date', 'desc')->take(5)->get();

        $aiInsight1 = "Saldo masjid saat ini sebesar Rp " . number_format($totalSaldo, 0, ',', '.') . ".";
        $aiInsight2 = "Manajemen kas terpantau cukup aktif bulan ini.";

        return view('dashboard', compact(
            'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 
            'surplus', 'recentTransactions', 'aiInsight1', 'aiInsight2', 'chartData'
        ));
    }
}
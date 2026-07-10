<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil data saldo (All Time)
        $totalPemasukan = Transaction::where('type', 'income')->sum('amount') ?: 0;
        $totalPengeluaran = Transaction::where('type', 'expense')->sum('amount') ?: 0;
        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $surplus = $totalSaldo;

        // 2. LOGIKA CHART BATANG MANUAL (6 Bulan Terakhir)
        $tempData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
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
        $maxInTemp = collect($tempData)->flatMap(fn($item) => [$item['income_raw'], $item['expense_raw']])->max();
        $limitMax = $maxInTemp > 0 ? $maxInTemp : 1; // Jika semua nol, bagi 1

        $chartData = [];
        foreach ($tempData as $data) {
            // Hitung persentase tinggi batang HTML/CSS
            $pemasukanHeight = ($data['income_raw'] / $limitMax) * 100;
            $pengeluaranHeight = ($data['expense_raw'] / $limitMax) * 100;

            $chartData[] = [
                'bulan' => $data['bulan'],
                // Jika ada uangnya, minimal kasih tinggi 10% supaya tetap kelihatan batangnya di UI
                'masuk' => $data['income_raw'] > 0 ? max($pemasukanHeight, 10) : 0,
                'keluar' => $data['expense_raw'] > 0 ? max($pengeluaranHeight, 10) : 0,
                'income_raw' => $data['income_raw'], // Kita simpan raw data-nya buat text tooltip/angka di view
                'expense_raw' => $data['expense_raw'],
            ];
        }

        // 3. TAMBAHAN: Data Alokasi Pengeluaran per Kategori (Bulan Ini) buat Pie/Doughnut Chart
        $expenseByCategory = Transaction::where('type', 'expense')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $pieLabels = $expenseByCategory->pluck('category');
        $pieData = $expenseByCategory->pluck('total');

        // 4. Ambil 5 Transaksi Terakhir
        $recentTransactions = Transaction::orderBy('date', 'desc')->take(5)->get();

        // 5. AI Insights Sederhana
        $aiInsight1 = "Saldo masjid saat ini sebesar Rp " . number_format($totalSaldo, 0, ',', '.') . ".";
        $aiInsight2 = $totalSaldo > 0 
            ? "Manajemen kas terpantau aman dan surplus, siap dialokasikan untuk program umat."
            : "Manajemen kas terpantau cukup aktif bulan ini.";

        // Kirim semua variabel ke view dashboard
        return view('dashboard', compact(
            'totalPemasukan', 
            'totalPengeluaran', 
            'totalSaldo', 
            'surplus', 
            'chartData', 
            'recentTransactions', 
            'aiInsight1', 
            'aiInsight2',
            'pieLabels',
            'pieData'
        ));
    }
}
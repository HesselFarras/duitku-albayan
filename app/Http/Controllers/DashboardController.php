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
        // 1. Ambil data saldo (All Time) - KECUALIKAN KATEGORI MUTASI KAS
        $totalPemasukan = Transaction::where('type', 'income')
            ->where('category', '!=', 'Mutasi Kas') // <-- Biar mutasi masuk ga dihitung pemasukan organisasi
            ->sum('amount') ?: 0;

        $totalPengeluaran = Transaction::where('type', 'expense')
            ->where('category', '!=', 'Mutasi Kas') // <-- Biar mutasi keluar ga dihitung pengeluaran organisasi
            ->sum('amount') ?: 0;

        $totalSaldo = $totalPemasukan - $totalPengeluaran;
        $surplus = $totalSaldo;

        // --- UPDATE UTAMA: HITUNG SALDO SPESIFIK KANTONG KAS (CASH vs BANK) ---
        $saldoCash = DB::table('transactions')
            ->join('wallets', 'transactions.wallet_id', '=', 'wallets.id')
            ->where('wallets.slug', 'cash')
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
            ->value('total') ?? 0;

        $saldoBank = DB::table('transactions')
            ->join('wallets', 'transactions.wallet_id', '=', 'wallets.id')
            ->where('wallets.slug', 'bank')
            ->selectRaw("SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as total")
            ->value('total') ?? 0;
        // ----------------------------------------------------------------------

        // 2. LOGIKA CHART BATANG MANUAL (6 Bulan Terakhir)
        $tempData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $start = $date->copy()->startOfMonth()->toDateString();
            $end = $date->copy()->endOfMonth()->toDateString();

            // KECUALIKAN MUTASI KAS BIAR GRAFIKNYA STERIL
            $income = Transaction::where('type', 'income')
                ->where('category', '!=', 'Mutasi Kas') // <-- Selipkan ini
                ->whereBetween('date', [$start, $end])
                ->sum('amount') ?: 0;

            $expense = Transaction::where('type', 'expense')
                ->where('category', '!=', 'Mutasi Kas') // <-- Selipkan ini
                ->whereBetween('date', [$start, $end])
                ->sum('amount') ?: 0;

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

        // 3. Data Alokasi Pengeluaran per Kategori (Bulan Ini) buat Pie/Doughnut Chart
        $expenseByCategory = Transaction::where('type', 'expense')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->get();

        $pieLabels = $expenseByCategory->pluck('category');
        $pieData = $expenseByCategory->pluck('total');

        // 4. Ambil 5 Transaksi Terakhir (Diload dengan relasi wallet agar badge di view aman)
        $recentTransactions = Transaction::with('wallet')->orderBy('date', 'desc')->take(5)->get();

        // 5. AI Insights Sederhana
        $aiInsight1 = "Saldo kas saat ini sebesar Rp " . number_format($totalSaldo, 0, ',', '.') . ".";
        $aiInsight2 = $totalSaldo > 0 
            ? "Manajemen kas terpantau aman dan surplus, siap dialokasikan untuk program organisasi."
            : "Manajemen kas terpantau cukup aktif bulan ini.";

        // Kirim semua variabel beserta variabel kantong kas baru ke view dashboard
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
            'pieData',
            'saldoCash', // <-- Variabel baru terlempar aman ke view
            'saldoBank'  // <-- Variabel baru terlempar aman ke view
        ));
    }
}
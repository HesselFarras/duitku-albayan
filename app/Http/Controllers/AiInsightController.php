<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Carbon\Carbon;

class AiInsightController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->get('bulan', Carbon::now()->month);
        $tahun = $request->get('tahun', Carbon::now()->year);

        // 1. Ambil data transaksi bulan terpilih
        $transactions = Transaction::whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->get();

        // 2. Hitung agregasi data untuk disuapkan ke AI
        $totalMasuk = $transactions->whereIn('type', ['income', 'INCOME'])->sum('amount');
        $totalKeluar = $transactions->whereIn('type', ['expense', 'EXPENSE'])->sum('amount');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        // Hitung pengeluaran terbesar berdasarkan teks kategori (string biasa)
        $kategoriTerbesar = $transactions->whereIn('type', ['expense', 'EXPENSE'])
            ->groupBy('category')
            ->map(function ($group) {
                return $group->sum('amount');
            })->sortDesc()->keys()->first() ?? 'Tidak ada pengeluaran';

        // 3. PROSES GENERATE INSIGHT (Skenario Rules-Based Pintar)
        $insights = [];
        if ($grandTotal = ($totalMasuk + $totalKeluar)) {
            $rasioPengeluaran = ($totalKeluar / ($totalMasuk ?: 1)) * 100;
            
            if ($rasioPengeluaran > 80) {
                $insights['status'] = 'Kritis / Boros';
                $insights['color'] = 'text-[#BA1A1A] bg-[#FFDAD6]';
                $insights['kesimpulan'] = "Arus kas bulan ini mendekati batas aman. Pengeluaran mencapai " . round($rasioPengeluaran) . "% dari total pemasukan masuk.";
                $insights['rekomendasi'] = "Disarankan untuk menunda pengeluaran non-mendesak di kategori **{$kategoriTerbesar}** dan menggalakkan program infaq subuh atau donasi khusus.";
            } elseif ($rasioPengeluaran > 40) {
                $insights['status'] = 'Wajar / Stabil';
                $insights['color'] = 'text-[#8D4B00] bg-[#FFDCC3]';
                $insights['kesimpulan'] = "Kondisi keuangan masjid dalam zona aman dan stabil. Alokasi dana kas berjalan cukup seimbang.";
                $insights['rekomendasi'] = "Pertahankan rasio ini. Sisa saldo akhir sebesar Rp " . number_format($saldoAkhir, 0, ',', '.') . " dapat dialokasikan sebagian ke tabungan jangka panjang (dana abadi/renovasi).";
            } else {
                $insights['status'] = 'Surplus Tinggi';
                $insights['color'] = 'text-[#526050] bg-[#D8E7D2]';
                $insights['kesimpulan'] = "Luar biasa! Masjid mengalami surplus dana yang sangat tinggi bulan ini karena minimnya pengeluaran operasional.";
                $insights['rekomendasi'] = "Waktunya mengoptimalkan dana umat! DKM dapat menyalurkan surplus ini ke program sosial baru, seperti modal usaha jamaah, beasiswa anak yatim, atau agenda kegiatan bernilai produktif lainnya.";
            }
        } else {
            $insights['status'] = 'Data Kosong';
            $insights['color'] = 'text-[#887364] bg-[#F4F4F3]';
            $insights['kesimpulan'] = "Belum ada rekaman mutasi kas pada periode bulan ini.";
            $insights['rekomendasi'] = "Silakan masukkan data transaksi terlebih dahulu di menu Buku Kas agar AI dapat menganalisis kesehatan keuangan masjid.";
        }

        return view('ai.index', compact('totalMasuk', 'totalKeluar', 'saldoAkhir', 'bulan', 'tahun', 'insights', 'kategoriTerbesar'));
    }
}
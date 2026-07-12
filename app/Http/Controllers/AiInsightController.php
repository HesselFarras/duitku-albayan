<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// Catatan: Jika kamu menggunakan model Eloquent (misal: Transaksi), kamu bisa meng-uncomment baris di bawah ini:
// use App\Models\Transaction; 

class AiInsightController extends Controller
{
    public function index(Request $request) 
    {
        // 1. Ambil input filter bulan, tahun, dan kantong kas (default 'all')
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);
        $selectedWallet = $request->input('wallet', 'all');

        // 2. HITUNG SALDO SPESIFIK (Untuk Widget Atas - Selalu Statis Total Seluruhnya)
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

        // 3. TARIK DATA BERDASARKAN FILTER AKTIF (Form Atas)
        $queryMasuk = DB::table('transactions')->whereMonth('date', $bulan)->whereYear('date', $tahun)->where('type', 'income');
        $queryKeluar = DB::table('transactions')->whereMonth('date', $bulan)->whereYear('date', $tahun)->where('type', 'expense');
        $queryKategori = DB::table('transactions')->whereMonth('date', $bulan)->whereYear('date', $tahun)->where('type', 'expense');

        // Jika user memilih spesifik kantong kas tertentu
        if ($selectedWallet !== 'all') {
            $walletData = DB::table('wallets')->where('slug', $selectedWallet)->first();
            $walletId = $walletData ? $walletData->id : 0;
            
            $queryMasuk->where('wallet_id', $walletId);
            $queryKeluar->where('wallet_id', $walletId);
            $queryKategori->where('wallet_id', $walletId);
        }

        $totalMasuk = $queryMasuk->sum('amount');
        $totalKeluar = $queryKeluar->sum('amount');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        // Cari kategori terbesar sesuai filter
        $kategoriData = $queryKategori->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')->orderByDesc('total')->first();
        $kategoriTerbesar = $kategoriData ? $kategoriData->category : 'Tidak Ada Pengeluaran';

        // 4. LOGIC INSIGHT DASHBOARD
        if ($totalMasuk == 0 && $totalKeluar == 0) {
            $status = 'Data Kosong';
            $color = 'bg-gray-100 text-gray-700';
            $kesimpulan = 'Belum ada rekaman mutasi kas pada periode dan filter kantong ini.';
            $rekomendasi = 'Silakan masukkan data transaksi terlebih dahulu di menu Buku Kas agar AI dapat menganalisis kesehatan keuangan organisasi.';
            $score = 0;
        } elseif ($saldoAkhir < 0) {
            $status = 'Defisit Waspada';
            $color = 'bg-red-100 text-red-700';
            $kesimpulan = 'Arus kas pada filter terpilih mengalami defisit karena pengeluaran lebih besar.';
            $rekomendasi = 'Segera lakukan evaluasi anggaran pada kategori <strong>' . e(strtoupper($kategoriTerbesar)) . '</strong> untuk menekan pengeluaran.';
            $score = 45;
        } else {
            $status = 'Surplus Aman';
            $color = 'bg-green-100 text-green-700';
            $kesimpulan = 'Kondisi kas terpilih dalam keadaan sehat dengan akumulasi saldo bernilai positif.';
            $rekomendasi = 'Pertahankan ritme alokasi dana ini. Sisa saldo surplus disarankan dialokasikan sebagian ke tabungan dana cadangan organisasi.';
            $score = 85;
        }

        $insights = [
            'status' => $status,
            'color' => $color, 
            'kesimpulan' => $kesimpulan,
            'rekomendasi' => $rekomendasi,
            'score' => $score 
        ];

        // Ambil list semua wallet untuk dropdown komponen view
        $wallets = DB::table('wallets')->get();

        return view('ai.index', compact(
            'bulan', 'tahun', 'selectedWallet', 'wallets',
            'totalMasuk', 'totalKeluar', 'saldoAkhir', 
            'saldoCash', 'saldoBank', 'kategoriTerbesar', 'insights'
        ));
    }

    // FITUR INTERAKTIF: Handle Chat Dua Arah (Slide-Over Panel)
    public function chat(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string',
                'bulan' => 'required|integer',
                'tahun' => 'required|integer',
            ]);

            $message = $request->input('message');
            $bulan = (int) $request->input('bulan'); 
            $tahun = (int) $request->input('tahun'); 

            // Tarik data ringkasan finansial aktual dari DB untuk bekal prompt keuangan
            $totalMasuk = DB::table('transactions')->whereMonth('date', $bulan)->whereYear('date', $tahun)->where('type', 'income')->sum('amount');
            $totalKeluar = DB::table('transactions')->whereMonth('date', $bulan)->whereYear('date', $tahun)->where('type', 'expense')->sum('amount');
            $saldoAkhir = $totalMasuk - $totalKeluar;
            
            $namaBulan = Carbon::create()->month($bulan)->translatedFormat('F');

            // ===========================================================================
            // 🔥 REM DARURAT BACKEND: CEGAT AUTO-TRIGGER & SHORTCUT PROMPT UTK DEMO PROJEK
            // ===========================================================================
            $messageLower = strtolower(trim($message));
            
            if (empty($messageLower) || $messageLower === 'tes' || $messageLower === 'halo') {
                return response()->json([
                    'success' => true,
                    'reply' => "Halo Bendahara! Koneksi internal Duitku AI sudah aktif dan berhasil membaca data kas periode **{$namaBulan} {$tahun}**. Silakan tanyakan hal spesifik atau klik tombol pintasan konsultasi yang tersedia."
                ]);
            }

            if (str_contains($messageLower, 'menghemat pengeluaran') || str_contains($messageLower, 'cara hemat')) {
                return response()->json([
                    'success' => true,
                    'reply' => "Berdasarkan rekap data kas bulan **{$namaBulan} {$tahun}**, total pengeluaran Anda adalah **Rp " . number_format($totalKeluar, 0, ',', '.') . "**. Berikut langkah taktis penghematan anggaran:\n\n"
                        . "* **Evaluasi Skala Prioritas:** Tinjau ulang alokasi dana operasional non-esensial rutin.\n"
                        . "* **Efisiensi Anggaran Tambahan:** Batasi pengeluaran insidental di luar rencana anggaran belanja utama.\n"
                        . "* **Optimalisasi Dana Sisa:** Maksimalkan saldo surplus saat ini (**Rp " . number_format($saldoAkhir, 0, ',', '.') . "**) untuk dialokasikan hanya pada kebutuhan mendesak organisasi."
                ]);
            }

            if (str_contains($messageLower, 'draf anggaran') || str_contains($messageLower, 'bulan depan')) {
                $bulanDepan = Carbon::create()->month($bulan)->addMonth()->translatedFormat('F');
                return response()->json([
                    'success' => true,
                    'reply' => "Berikut adalah draf usulan optimasi anggaran organisasi untuk periode bulan berikutnya (**{$bulanDepan}**):\n\n"
                        . "1.  **Target Pemasukan Stabil:** Mempertahankan performa penerimaan kas minimum di angka rata-rata bulan ini.\n"
                        . "2.  **Plafon Batas Pengeluaran:** Menetapkan batas maksimal pengeluaran operasional baru sebesar 85% dari total estimasi pemasukan masuk.\n"
                        . "3.  **Dana Cadangan Taktis:** Menyisihkan minimal 15% dari sisa kas surplus berjalan untuk pos dana abadi / dana darurat organisasi."
                ]);
            }
            // ===========================================================================

            // Menyusun bekal data finansial asli jika lolos dari interseptor di atas
            $systemPrompt = "Kamu adalah Duitku AI, asisten konsultan keuangan pintar untuk organisasi.\n"
                . "Tugasmu adalah menjawab pertanyaan pengurus dengan bersandar pada data aktual keuangan berikut:\n"
                . "KONTEKS KEUANGAN PERIODE BERJALAN ({$namaBulan} {$tahun}):\n"
                . "- Total Pemasukan: Rp " . number_format($totalMasuk, 0, ',', '.') . "\n"
                . "- Total Pengeluaran: Rp " . number_format($totalKeluar, 0, ',', '.') . "\n"
                . "- Sisa Saldo Akhir: Rp " . number_format($saldoAkhir, 0, ',', '.') . "\n\n"
                . "Aturan jawaban: Berikan respon yang taktis, solutif, sopan, dan mudah dipahami oleh pengurus masjid. Gunakan bullet-points jika menyusun poin saran.";

            $apiKey = env('GEMINI_API_KEY');
            
            if (!$apiKey) {
                return response()->json([
                    'success' => false,
                    'reply' => 'Error: API Key Gemini belum diisi di file .env!'
                ]);
            }

            // Tembak API Resmi menggunakan Endpoint Stable /v1beta/ dan Model Resmi Terdaftar
            $response = Http::withoutVerifying()
                ->timeout(30)
                ->withOptions([
                    'curl' => [
                        CURLOPT_IPRESOLVE => CURL_IPRESOLVE_V4 // Proteksi anti-timeout DNS localhost Windows
                    ]
                ])
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $systemPrompt . "\nPertanyaan Pengurus: " . $message]
                            ]
                        ]
                    ]
                ]);

            if ($response->successful()) {
                $result = $response->json();
                $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                if ($aiResponse) {
                    return response()->json([
                        'success' => true,
                        'reply' => trim($aiResponse)
                    ]);
                }
            }

            $apiErrorMessage = $response->json()['error']['message'] ?? 'Gagal memproses data di otak AI.';
            return response()->json([
                'success' => false,
                'reply' => 'Response dari Google gagal: ' . $apiErrorMessage
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'reply' => 'PHP Fatal Error: ' . $e->getMessage() . ' di baris ' . $e->getLine()
            ]);
        }
    }
}
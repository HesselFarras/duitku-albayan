// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Manrope', 'sans-serif'],
                mono: ['Inter', 'monospace'],
            },
            colors: {
                // Brand
                brand: {
                    DEFAULT: '#8D4B00',
                    dark:    '#7a4100',
                    light:   '#FFDCC3',
                    muted:   '#887364',
                },
                // Neutral warm
                warm: {
                    50:  '#F9F9F8',
                    100: '#F4F4F3',
                    200: '#E8E8E7',
                    300: '#DBC2B0',
                    400: '#887364',
                    500: '#554336',
                    600: '#4B4641',
                    700: '#1A1C1C',
                },
                // Green (surplus / income)
                sage: {
                    DEFAULT: '#526050',
                    light:   '#D8E7D2',
                    text:    '#526050',
                },
                // Gray (expense)
                stone: {
                    DEFAULT: '#6A635E',
                    light:   '#EAE1DA',
                },
            },
            borderRadius: {
                '4xl': '48px',
                '3xl': '32px',
            },
            boxShadow: {
                card: '0px 24px 48px -12px rgba(85, 67, 54, 0.08)',
                fab:  '0px 25px 50px -12px rgba(0, 0, 0, 0.25)',
                nav:  '24px 0px 48px -12px rgba(85, 67, 54, 0.08)',
            },
        },
    },
    plugins: [],
}

// ================================================================
// CATATAN INTEGRASI
// ================================================================
//
// 1. STRUKTUR FILE
//    resources/
//    ├── views/
//    │   ├── layouts/
//    │   │   └── app.blade.php      ← layout sidebar + topbar
//    │   └── dashboard.blade.php   ← halaman utama
//    └── css/app.css               ← Tailwind imports
//
// 2. GOOGLE FONTS
//    Sudah ada di <head> layout. Jika pakai Vite, bisa install via npm:
//    npm install @fontsource/manrope @fontsource/inter
//    lalu import di resources/css/app.css:
//    @import '@fontsource/manrope/variable.css';
//    @import '@fontsource/inter';
//
// 3. ROUTE CONTOH (routes/web.php)
//    Route::get('/dashboard', [DashboardController::class, 'index'])
//         ->middleware('auth')
//         ->name('dashboard');
//
// 4. CONTROLLER CONTOH (app/Http/Controllers/DashboardController.php)
//    public function index() {
//        return view('dashboard', [
//            'totalSaldo'      => Transaksi::saldo(),
//            'totalPemasukan'  => Transaksi::thisMonth()->pemasukan(),
//            'totalPengeluaran'=> Transaksi::thisMonth()->pengeluaran(),
//            'surplus'         => Transaksi::thisMonth()->surplus(),
//            'jumlahDonatur'   => Donatur::thisMonth()->count(),
//            'transactions'    => Transaksi::latest()->take(3)->get(),
//            'programs'        => Program::aktif()->get(),
//            'chartData'       => Transaksi::chartEnamBulan(),
//            'totalJamaah'     => Jamaah::aktif()->count(),
//        ]);
//    }
//
// 5. INSTALL TAILWIND (jika belum)
//    npm install -D tailwindcss @tailwindcss/vite
//    npx tailwindcss init
//
// 6. resources/css/app.css
//    @tailwind base;
//    @tailwind components;
//    @tailwind utilities;

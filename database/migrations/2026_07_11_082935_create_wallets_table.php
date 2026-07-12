<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Buat tabel master wallets
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Cash", "Bank"
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Insert data default langsung (Cash & Bank)
        DB::table('wallets')->insert([
            ['name' => 'Cash', 'slug' => 'cash', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Bank', 'slug' => 'bank', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 3. Modifikasi tabel transactions untuk menghubungkannya ke wallets
        Schema::table('transactions', function (Blueprint $table) {
            // Kita set nullable dulu agar data transaksi lama lu (jika ada) tidak error saat migrasi
            $table->foreignId('wallet_id')->nullable()->after('id')->constrained('wallets')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['wallet_id']);
            $table->dropColumn('wallet_id');
        });
        Schema::dropIfExists('wallets');
    }
};
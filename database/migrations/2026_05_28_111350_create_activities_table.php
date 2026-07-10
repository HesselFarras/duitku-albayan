<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Nama Kegiatan (cth: Pengajian Akbar, Santunan Anak Yatim)
            $table->date('date'); // Tanggal pelaksanaan
            $table->time('time'); // Waktu mulai (cth: 09:00)
            $table->string('location'); // Lokasi (cth: Ruang Utama Masjid, Aula Basement)
            $table->string('funding_source'); // Sumber dana (cth: Kas Utama, Zakat, Infaq Terikat)
            $table->decimal('budget', 15, 2)->default(0); // Anggaran yang dialokasikan
            $table->enum('status', ['UPCOMING', 'ONGOING', 'COMPLETED'])->default('UPCOMING'); // Status agenda
            $table->text('description')->nullable(); // Detail ringkas acara
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
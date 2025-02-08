<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_masuk_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('pengirim');
            $table->string('penerima');
            $table->date('tanggal_surat');
            $table->string('perihal');
            $table->string('sifat');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['Belum Ditandatangani', 'Sudah Ditandatangani'])->default('Belum Ditandatangani');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_masuk_desa');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nama_siswa');
            // kode unik untuk menghubungkan ke database kurikulum

            $table->string('status')->nullable();
            $table->string('ktp')->unique();
            $table->string('email')->unique();
            $table->date('tanggal_lahir');
            $table->string('password');
            $table->string('nomor_pendaftaran')->unique();
            // ini berupa 6 angka pertama adalah nomor pendaftaran + dua angka terakhir tahun mendaftar

            $table->year('tahun_daftar');
            // field ini nantinya berguna untuk filtering data

            $table->rememberToken();
            // yang ini pasti dibutuhkan untuk siswa ketika login kembali

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};

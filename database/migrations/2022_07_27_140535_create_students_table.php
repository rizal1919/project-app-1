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
            $table->foreignId('nis');
            // lets say ada 3 program yang bisa diikuti oleh siswa ['1','9','12']

            $table->integer('ktp')->unique();
            $table->string('email')->unique();
            $table->date('tanggal_lahir');
            $table->string('password');
            $table->string('nomor_pendaftaran');
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

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

            // formA
            $table->string('picture')->nullable();
            $table->string('nama_siswa');
            $table->string('nama_panggilan_siswa');
            $table->string('jenis_kelamin');
            $table->string('ktp')->unique();
            $table->string('email')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('agama');
            $table->string('nama_jalan_ktp');
            $table->string('rt_ktp');
            $table->string('rw_ktp');
            $table->string('nama_desa_ktp');
            $table->string('nama_kecamatan_ktp');
            $table->string('nama_jalan_domisili');
            $table->string('rt_domisili');
            $table->string('rw_domisili');
            $table->string('nama_desa_domisili');
            $table->string('nama_kecamatan_domisili');
            $table->string('tempat_tinggal');
            $table->string('transportasi');
            $table->bigInteger('no_hp')->unique();
            $table->string('asal_sekolah');
            $table->string('kota_asal_sekolah');


            // formB
            $table->string('nama_ayah');
            $table->string('nama_ibu');
            $table->date('tanggal_lahir_ayah');
            $table->date('tanggal_lahir_ibu');
            $table->string('pendidikan_ayah');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ayah');
            $table->string('pekerjaan_ibu');
            $table->integer('penghasilan_ayah');
            $table->integer('penghasilan_ibu');
            $table->string('keterangan_ayah');
            $table->string('keterangan_ibu');
            $table->string('nama_jalan_ortu'); 
            $table->string('rt_ortu');
            $table->string('rw_ortu');
            $table->string('nama_desa_ortu');
            $table->string('nama_kecamatan_ortu');

            // formC
            $table->integer('tinggi_badan');
            $table->integer('jarak_tempuh_sekolah');
            $table->integer('urutan_anak');
            $table->integer('jumlah_saudara');


            $table->year('tahun_daftar');
            // field ini nantinya berguna untuk filtering data
            
            $table->foreignId('pic_id')->nullable();
            // marketing

            $table->string('nomor_pendaftaran')->unique();
            // ini berupa 6 angka pertama adalah nomor pendaftaran + dua angka terakhir tahun mendaftar
            $table->string('password');
            // sama dengan nomor pendaftaran
            
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

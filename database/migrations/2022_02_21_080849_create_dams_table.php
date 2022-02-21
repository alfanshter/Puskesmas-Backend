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
        Schema::create('dams', function (Blueprint $table) {
            $table->id();
            $table->string('tpm');
            $table->string('desa');
            $table->string('pemilik');
            $table->string('alamat');  
            $table->string('karyawan');  
            $table->enum('ikl',['Memenuhi Syarat','Tidak Memenuhi Syarat']);
            $table->enum('ujisampel',['Memenuhi Syarat','Tidak Memenuhi Syarat','Belum Uji Sampel']);
            $table->enum('sertifikatpenjamaah',['Ada','Belum Ada']);
            $table->enum('laiksehat',['Ada','Belum Ada']);
            $table->enum('izinusaha',['Ada','Belum Ada']);
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
        Schema::dropIfExists('dams');
    }
};

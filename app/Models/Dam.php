<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dam extends Model
{
    use HasFactory;
      protected $fillable = [
        'tpm',
        'desa',
        'pemilik',
        'alamat',
        'karyawan',
        'ikl',
        'ujisampel',
        'sertifikatpenjamaah',
        'laiksehat',
        'izinusaha'
    ];
}

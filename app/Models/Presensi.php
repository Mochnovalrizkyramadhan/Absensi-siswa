<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public static function statuses(): array
    {
        return [
            'Hadir' => 'Hadir',
            'Izin' => 'Izin',
            'Sakit' => 'Sakit',
            'Alpha' => 'Alpha',
        ];
    }
}

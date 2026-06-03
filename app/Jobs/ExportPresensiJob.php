<?php

namespace App\Jobs;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ExportPresensiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $queue = 'exports';

    public function __construct(public array $filters = [])
    {
        $this->queue = 'exports';
    }

    public function handle(): void
    {
        $siswas = Siswa::with(['presensis' => function ($query) {
            if (! empty($this->filters['awal'])) {
                $query->where('tanggal', '>=', $this->filters['awal']);
            }
            if (! empty($this->filters['akhir'])) {
                $query->where('tanggal', '<=', $this->filters['akhir']);
            }
        }])->orderBy('nama')->get();

        $headers = ['Nama', 'NIS', 'Kelas', 'Jurusan', 'Hadir', 'Izin', 'Sakit', 'Alpha'];
        $rows = $siswas->map(function (Siswa $siswa) {
            $counts = $siswa->presensis->groupBy('status')->map->count();

            return [
                $siswa->nama,
                $siswa->nis,
                $siswa->kelas,
                $siswa->jurusan,
                $counts->get('Hadir', 0),
                $counts->get('Izin', 0),
                $counts->get('Sakit', 0),
                $counts->get('Alpha', 0),
            ];
        });

        $filename = 'exports/rekap-kehadiran-' . now()->format('Ymd-His') . '.csv';
        $csv = implode(',', $headers) . "\n";

        foreach ($rows as $row) {
            $csv .= implode(',', array_map(function ($value) {
                return '"' . str_replace('"', '""', $value) . '"';
            }, $row)) . "\n";
        }

        Storage::disk('local')->put($filename, $csv);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Jobs\ExportPresensiJob;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PresensiController extends Controller
{
    public function index(Request $request): View
    {
        $query = Presensi::with('siswa')->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        return view('presensi.index', [
            'presensis' => $query->paginate(15),
            'siswas' => Siswa::orderBy('nama')->get(),
            'filterTanggal' => $request->tanggal,
            'filterSiswa' => $request->siswa_id,
        ]);
    }

    public function create(): View
    {
        return view('presensi.create', [
            'siswas' => Siswa::orderBy('nama')->get(),
            'statuses' => Presensi::statuses(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:' . implode(',', array_keys(Presensi::statuses())),
            'keterangan' => 'nullable|string|max:500',
        ]);

        Presensi::updateOrCreate(
            ['siswa_id' => $request->siswa_id, 'tanggal' => $request->tanggal],
            $request->only(['status', 'keterangan'])
        );

        return redirect()->route('presensi.index')->with('success', 'Presensi berhasil disimpan.');
    }

    public function rekap(Request $request): View
    {
        $siswas = Siswa::with(['presensis' => function ($query) use ($request) {
            if ($request->filled('awal')) {
                $query->where('tanggal', '>=', $request->awal);
            }
            if ($request->filled('akhir')) {
                $query->where('tanggal', '<=', $request->akhir);
            }
        }])->orderBy('nama')->get();

        return view('rekap.index', [
            'siswas' => $siswas,
            'statuses' => Presensi::statuses(),
            'awal' => $request->awal,
            'akhir' => $request->akhir,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $siswas = Siswa::with(['presensis' => function ($query) use ($request) {
            if ($request->filled('awal')) {
                $query->where('tanggal', '>=', $request->awal);
            }
            if ($request->filled('akhir')) {
                $query->where('tanggal', '<=', $request->akhir);
            }
        }])->orderBy('nama')->get();

        $filename = 'rekap-kehadiran-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($siswas) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama', 'NIS', 'Kelas', 'Jurusan', 'Hadir', 'Izin', 'Sakit', 'Alpha']);

            foreach ($siswas as $siswa) {
                $counts = $siswa->presensis->groupBy('status')->map->count();
                fputcsv($handle, [
                    $siswa->nama,
                    $siswa->nis,
                    $siswa->kelas,
                    $siswa->jurusan,
                    $counts->get('Hadir', 0),
                    $counts->get('Izin', 0),
                    $counts->get('Sakit', 0),
                    $counts->get('Alpha', 0),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportQueued(Request $request): RedirectResponse
    {
        $request->validate([
            'awal' => 'nullable|date',
            'akhir' => 'nullable|date',
        ]);

        ExportPresensiJob::dispatch($request->only(['awal', 'akhir']))->onQueue('exports');

        return redirect()->route('rekap.index')->with('success', 'Export CSV telah dikirim ke antrian.');
    }
}

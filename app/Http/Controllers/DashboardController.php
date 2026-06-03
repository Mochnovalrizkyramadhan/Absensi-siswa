<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSiswas = Siswa::count();
        $totalPresensis = Presensi::count();
        $todayPresensis = Presensi::where('tanggal', today())->count();
        $statusCounts = Presensi::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();
        $recentPresensis = Presensi::with('siswa')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'totalSiswas' => $totalSiswas,
            'totalPresensis' => $totalPresensis,
            'todayPresensis' => $todayPresensis,
            'statusCounts' => $statusCounts,
            'recentPresensis' => $recentPresensis,
        ]);
    }
}

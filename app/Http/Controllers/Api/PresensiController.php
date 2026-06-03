<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PresensiController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Presensi::with('siswa')->orderBy('tanggal', 'desc');

        if ($request->filled('tanggal')) {
            $query->where('tanggal', $request->tanggal);
        }

        if ($request->filled('siswa_id')) {
            $query->where('siswa_id', $request->siswa_id);
        }

        return response()->json($query->paginate(20));
    }

    public function show(Presensi $presensi): JsonResponse
    {
        return response()->json($presensi->load('siswa'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:' . implode(',', array_keys(Presensi::statuses())),
            'keterangan' => 'nullable|string|max:500',
        ]);

        $presensi = Presensi::updateOrCreate(
            ['siswa_id' => $validated['siswa_id'], 'tanggal' => $validated['tanggal']],
            $request->only(['status', 'keterangan'])
        );

        return response()->json($presensi->load('siswa'), 201);
    }

    public function update(Request $request, Presensi $presensi): JsonResponse
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal' => 'required|date',
            'status' => 'required|in:' . implode(',', array_keys(Presensi::statuses())),
            'keterangan' => 'nullable|string|max:500',
        ]);

        $presensi->update($validated);

        return response()->json($presensi->load('siswa'));
    }

    public function destroy(Presensi $presensi): JsonResponse
    {
        $presensi->delete();

        return response()->json(['message' => 'Data presensi berhasil dihapus.']);
    }
}

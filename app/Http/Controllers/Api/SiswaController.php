<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SiswaController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Siswa::orderBy('nama');

        if ($request->filled('q')) {
            $query->where('nama', 'like', '%' . $request->q . '%');
        }

        return response()->json($query->paginate(20));
    }

    public function show(Siswa $siswa): JsonResponse
    {
        return response()->json($siswa);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswas,nis',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $siswa = Siswa::create($validated);

        return response()->json($siswa, 201);
    }

    public function update(Request $request, Siswa $siswa): JsonResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $siswa->update($validated);

        return response()->json($siswa);
    }

    public function destroy(Siswa $siswa): JsonResponse
    {
        $siswa->delete();

        return response()->json(['message' => 'Data siswa berhasil dihapus.']);
    }
}

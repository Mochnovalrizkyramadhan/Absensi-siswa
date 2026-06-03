<?php

namespace App\Http\Controllers;

use App\Http\Attributes\UseMiddleware;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

#[UseMiddleware(\App\Http\Middleware\EnsureJsonResponse::class)]
class SiswaController extends Controller
{
    public function index(): View
    {
        return view('siswa.index', [
            'siswas' => Siswa::orderBy('nama')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('siswa.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswas,nis',
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $siswa = Siswa::create($request->only(['nama', 'nis', 'kelas', 'jurusan']));

        if ($request->prefersJsonResponses()) {
            return response()->json(['message' => 'Data siswa berhasil disimpan.', 'data' => $siswa], 201);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil disimpan.');
    }

    public function edit(Siswa $siswa): View
    {
        return view('siswa.edit', compact('siswa'));
    }

    public function update(Request $request, Siswa $siswa): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:siswas,nis,' . $siswa->id,
            'kelas' => 'nullable|string|max:50',
            'jurusan' => 'nullable|string|max:100',
        ]);

        $siswa->update($request->only(['nama', 'nis', 'kelas', 'jurusan']));

        if ($request->prefersJsonResponses()) {
            return response()->json(['message' => 'Data siswa berhasil diperbarui.', 'data' => $siswa]);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $siswa->delete();

        if (request()->prefersJsonResponses()) {
            return response()->json(['message' => 'Data siswa berhasil dihapus.']);
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}

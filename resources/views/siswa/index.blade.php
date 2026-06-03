@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="buttons">
            <a class="button" href="{{ route('siswa.create') }}">Tambah Siswa</a>
            <a class="button secondary" href="{{ route('presensi.create') }}">Tambah Presensi</a>
        </div>

        <h1>Daftar Siswa</h1>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->jurusan }}</td>
                        <td>
                            <a class="button secondary" href="{{ route('siswa.edit', $siswa) }}">Edit</a>
                            <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="button danger" type="submit" onclick="return confirm('Hapus siswa ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data siswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $siswas->links() }}
    </div>
@endsection

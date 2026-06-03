@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="buttons">
            <a class="button" href="{{ route('presensi.index') }}">Daftar Presensi</a>
            <a class="button secondary" href="{{ route('siswa.index') }}">Data Siswa</a>
            <a class="button" href="{{ route('rekap.export') }}?{{ http_build_query(request()->all()) }}">Export CSV</a>
        </div>

        <h1>Rekap Kehadiran</h1>

        <form method="GET" class="card">
            <div class="form-row">
                <div>
                    <label for="awal">Tanggal Awal</label>
                    <input id="awal" type="date" name="awal" value="{{ $awal }}">
                </div>
                <div>
                    <label for="akhir">Tanggal Akhir</label>
                    <input id="akhir" type="date" name="akhir" value="{{ $akhir }}">
                </div>
                <div style="align-self:flex-end;">
                    <button class="button" type="submit">Terapkan</button>
                </div>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    @foreach($statuses as $status)
                        <th>{{ $status }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->kelas }}</td>
                        <td>{{ $siswa->jurusan }}</td>
                        @foreach($statuses as $status)
                            <td>{{ $siswa->presensis->where('status', $status)->count() }}</td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 4 + count($statuses) }}">Belum ada data rekap.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

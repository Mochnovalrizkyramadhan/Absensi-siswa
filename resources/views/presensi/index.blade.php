@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="buttons">
            <a class="button" href="{{ route('presensi.create') }}">Tambah Presensi</a>
            <a class="button secondary" href="{{ route('siswa.index') }}">Data Siswa</a>
        </div>

        <h1>Daftar Presensi</h1>

        <form method="GET" class="card">
            <div class="form-row">
                <div>
                    <label for="tanggal">Tanggal</label>
                    <input id="tanggal" type="date" name="tanggal" value="{{ $filterTanggal }}">
                </div>
                <div>
                    <label for="siswa_id">Siswa</label>
                    <select id="siswa_id" name="siswa_id">
                        <option value="">Semua siswa</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" @selected($filterSiswa == $siswa->id)>{{ $siswa->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="align-self:flex-end;">
                    <button class="button" type="submit">Filter</button>
                </div>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>NIS</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($presensis as $presensi)
                    <tr>
                        <td>{{ $presensi->tanggal->format('Y-m-d') }}</td>
                        <td>{{ $presensi->siswa->nama }}</td>
                        <td>{{ $presensi->siswa->nis }}</td>
                        <td>{{ $presensi->status }}</td>
                        <td>{{ $presensi->keterangan }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data presensi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $presensis->withQueryString()->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Dashboard Absensi</h1>
        <p>Ringkasan data siswa dan presensi secara cepat.</p>

        <div class="buttons">
            <div class="card" style="padding:16px; flex:1; min-width:180px;">
                <h2>Total Siswa</h2>
                <p>{{ $totalSiswas }}</p>
            </div>
            <div class="card" style="padding:16px; flex:1; min-width:180px;">
                <h2>Total Presensi</h2>
                <p>{{ $totalPresensis }}</p>
            </div>
            <div class="card" style="padding:16px; flex:1; min-width:180px;">
                <h2>Presensi Hari Ini</h2>
                <p>{{ $todayPresensis }}</p>
            </div>
        </div>

        <div class="card" style="margin-top: 24px;">
            <h2>Status Presensi</h2>
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(['Hadir','Izin','Sakit','Alpha'] as $status)
                        <tr>
                            <td>{{ $status }}</td>
                            <td>{{ $statusCounts[$status] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card" style="margin-top: 24px;">
            <h2>Presensi Terakhir</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>NIS</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPresensis as $item)
                        <tr>
                            <td>{{ $item->tanggal->format('Y-m-d') }}</td>
                            <td>{{ $item->siswa->nama }}</td>
                            <td>{{ $item->siswa->nis }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">Belum ada presensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

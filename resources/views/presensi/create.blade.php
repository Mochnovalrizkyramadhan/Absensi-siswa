@extends('layouts.app')

@section('content')
    <div class="card">
        <a class="button secondary" href="{{ route('presensi.index') }}">Kembali ke Presensi</a>

        <h1>Tambah Presensi</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('presensi.store') }}" method="POST">
            @csrf
            <label for="siswa_id">Siswa</label>
            <select id="siswa_id" name="siswa_id" required>
                <option value="">Pilih siswa</option>
                @foreach($siswas as $siswa)
                    <option value="{{ $siswa->id }}" @selected(old('siswa_id') == $siswa->id)>{{ $siswa->nama }} ({{ $siswa->nis }})</option>
                @endforeach
            </select>

            <label for="tanggal">Tanggal</label>
            <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>

            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="">Pilih status</option>
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(old('status') == $value)>{{ $label }}</option>
                @endforeach
            </select>

            <label for="keterangan">Keterangan</label>
            <textarea id="keterangan" name="keterangan" rows="4">{{ old('keterangan') }}</textarea>

            <button class="button" type="submit">Simpan Presensi</button>
        </form>
    </div>
@endsection

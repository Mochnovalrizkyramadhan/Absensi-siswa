@extends('layouts.app')

@section('content')
    <div class="card">
        <a class="button secondary" href="{{ route('siswa.index') }}">Kembali ke Daftar Siswa</a>

        <h1>Tambah Siswa</h1>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('siswa.store') }}" method="POST">
            @csrf
            <label for="nama">Nama</label>
            <input id="nama" name="nama" value="{{ old('nama') }}" required>

            <label for="nis">NIS</label>
            <input id="nis" name="nis" value="{{ old('nis') }}" required>

            <label for="kelas">Kelas</label>
            <input id="kelas" name="kelas" value="{{ old('kelas') }}">

            <label for="jurusan">Jurusan</label>
            <input id="jurusan" name="jurusan" value="{{ old('jurusan') }}">

            <button class="button" type="submit">Simpan</button>
        </form>
    </div>
@endsection

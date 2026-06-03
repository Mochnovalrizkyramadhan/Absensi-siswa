<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f7f9fb; color: #1f2937; }
        .container { width: min(1100px, 100%); margin: 0 auto; padding: 24px; }
        .nav { background: #111827; color: #fff; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; gap: 18px; }
        .nav .brand { display:flex; align-items:center; gap:12px; }
        .nav .brand .title { color: #fff; font-weight: 700; font-size: 18px; text-decoration: none; }
        .nav .links { display:flex; gap:12px; align-items:center; }
        .nav a { color: #d1d5db; text-decoration: none; font-weight: 600; padding: 8px 10px; border-radius:6px; }
        .nav a:hover { color: #fff; background: rgba(255,255,255,0.03); }
        .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; box-shadow: 0 2px 8px rgba(15, 23, 42, 0.05); }
        .buttons { display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 16px; }
        .button { display: inline-block; background: #2563eb; color: #fff; text-decoration: none; padding: 10px 14px; border-radius: 8px; }
        .button.secondary { background: #6b7280; }
        .button.danger { background: #dc2626; }
        .alert { border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #e5e7eb; }
        th { background: #f3f4f6; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; margin-top: 6px; margin-bottom: 14px; }
        label { display: block; margin-top: 12px; font-weight: 600; }
        .form-row { display: grid; gap: 16px; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); }
    </style>
</head>
<body>
    <div class="nav">
        <div class="brand">
            <a href="{{ route('dashboard') }}" class="title">{{ config('app.name', 'Absensi Siswa') }}</a>
            <small style="color:#9ca3af;font-weight:600;">— Sistem Absensi</small>
        </div>
        <div class="links">
            <a href="{{ route('siswa.index') }}">Siswa</a>
            <a href="{{ route('presensi.index') }}">Presensi</a>
            <a href="{{ route('rekap.index') }}">Rekap</a>
        </div>
    </div>
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Siswa</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #222; }
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        .logo { width: 50px; margin-right: 16px; }
        .header-text { display: flex; flex-direction: column; justify-content: center; }
        .title { font-size: 22px; font-weight: bold; color: #2d3748; }
        .appname { font-size: 16px; color: #555; font-weight: bold; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #bbb; padding: 8px 10px; }
        th { background: #f7fafc; color: #2d3748; font-size: 13px; }
        tr:nth-child(even) { background: #f9f9f9; }
        tr:hover { background: #e2e8f0; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('image/logo-baru.png') }}" class="logo" alt="Logo">
        <div class="header-text">
            <div class="title">Data Siswa</div>
            @if(!empty($kelasDipilih))
                <div class="appname" style="font-size:13px;">Kelas: {{ $kelasDipilih }}</div>
            @endif
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 30%;">Nama Lengkap</th>
                <th style="width: 15%;">NIS</th>
                <th style="width: 15%;">Kelas</th>
                <th style="width: 15%;">Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($siswas as $siswa)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->nis }}</td>
                <td>{{ $siswa->kelas }}</td>
                <td>{{ $siswa->jenis_kelamin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
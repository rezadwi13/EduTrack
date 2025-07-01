<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Guru</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 12px; }
        th { background: #f2f2f2; }
        h2 { margin-bottom: 0; }
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        .logo { height: 40px; margin-right: 16px; }
        .header-text { display: flex; flex-direction: column; }
        .title { font-size: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('image/logo-baru.png') }}" class="logo" alt="Logo">
        <div class="header-text">
            <div class="title">Data Guru</div>
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 15%;">NIP</th>
                <th style="width: 20%;">Nama</th>
                <th style="width: 20%;">Email</th>
                <th style="width: 20%;">Mata Pelajaran</th>
                <th style="width: 10%;">Jenis Kelamin</th>
                <th style="width: 10%;">No HP</th>
            </tr>
        </thead>
        <tbody>
            @foreach($gurus as $guru)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $guru->nip }}</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->email }}</td>
                <td>{{ $guru->mata_pelajaran }}</td>
                <td>{{ $guru->jenis_kelamin }}</td>
                <td>{{ $guru->no_hp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 
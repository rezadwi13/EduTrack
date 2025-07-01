<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Nilai Siswa</title>
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
            <div class="title">Data Nilai Siswa</div>
            @if($kelas)
                <div style="font-size:13px;">Kelas: {{ $kelas }}</div>
            @endif
            @if($mapel)
                <div style="font-size:13px;">Mata Pelajaran: {{ $mapel->nama }}</div>
            @endif
            @if($semester)
                <div style="font-size:13px;">Semester: {{ $semester }}</div>
            @endif
        </div>
    </div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">Nama Siswa</th>
                <th style="width: 10%;">NIS</th>
                <th style="width: 10%;">Kelas</th>
                <th style="width: 20%;">Mata Pelajaran</th>
                <th style="width: 10%;">Semester</th>
                <th style="width: 10%;">Nilai</th>
                <th style="width: 15%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nilais as $nilai)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td>{{ $nilai->siswa->nama ?? '-' }}</td>
                <td>{{ $nilai->siswa->nis ?? '-' }}</td>
                <td>{{ $nilai->siswa->kelas ?? '-' }}</td>
                <td>{{ $nilai->mataPelajaran->nama ?? '-' }}</td>
                <td>{{ $nilai->semester }}</td>
                <td>{{ $nilai->nilai }}</td>
                <td>{{ $nilai->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 
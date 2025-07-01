<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jadwal Pelajaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; font-size: 12px; }
        th { background: #f2f2f2; }
        h2 { margin-bottom: 0; }
        .info { margin-top: 0; font-size: 14px; }
    </style>
</head>
<body>
    <h2>Jadwal Pelajaran</h2>
    @if($siswa)
        <div class="info">Nama: <b>{{ $siswa->nama }}</b> | Kelas: <b>{{ $kelas }}</b></div>
    @endif
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Hari</th>
                <th>Jam</th>
                <th>Mata Pelajaran</th>
                <th>Guru</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grouped = $jadwals->groupBy('hari');
                $no = 1;
            @endphp
            @foreach($grouped as $hari => $jadwalHari)
                @foreach($jadwalHari as $i => $jadwal)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>@if($i == 0) {{ $hari }} @endif</td>
                    <td>{{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}</td>
                    <td>{{ $jadwal->mataPelajaran?->nama ?? '-' }}</td>
                    <td>{{ $jadwal->guru?->name ?? '-' }}</td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>
</html> 
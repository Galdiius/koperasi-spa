<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>

    </style>
    <title>Laporan</title>
</head>
<body>
        <h1>Laporan</h1>
        <h5>Laporan tanggal {{ $data['mulai'] }} sampai {{ $data['akhir'] }}</h5>
        <hr>
        <h5>Pinjaman</h5>
        <hr>
        <table class="table" width="100%"  align="center">
            <tr align="center">
                <td>No</td>
                <td>Nama</td>
                <td>tanggal</td>
                <td>Lama pinjam</td>
                <td>Jumlah</td>
                <td>Petugas</td>
            </tr>
            @forelse($data['pinjaman'] as $pinjaman)
            <tr align="center">
                <td>1</td>
                <td>{{ $pinjaman->anggota }}</td>
                <td>{{ $pinjaman->tanggal }}</td>
                <td>{{ $pinjaman->lama_pinjam }}</td>
                <td>{{ $pinjaman->jumlah }}</td>
                <td>{{ $pinjaman->petugas }}</td>
            </tr>
                @empty
                <tr align="center">
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse
        </table>
        <hr>
        <h5>Simpanan</h5>
        <hr>
        <table class="table" width="100%" align="center">
            <tr align="center">
                <td>No</td>
                <td>Nama anggota</td>
                <td>tanggal</td>
                <td>Jenis simpanan</td>
                <td>jumlah</td>
                <td>Petugas</td>
            </tr>
            @forelse($data['simpanan'] as $simpanan)
            <tr align="center">
                <td>1</td>
                <td>{{ $simpanan->anggota }}</td>
                <td>{{ $simpanan->tanggal }}</td>
                <td>{{ $simpanan->simpanan }}</td>
                <td>{{ $simpanan->jumlah }}</td>
                <td>{{ $simpanan->petugas }}</td>
            </tr>
            @empty
                <tr align="center">
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse

        </table>
        <hr>
        <h5>Penarikan</h5>
        <hr>
        <table class="table" width="100%" align="center">
            <tr align="center">
                <td>No</td>
                <td>Nama anggota</td>
                <td>tanggal</td>
                <td>jumlah</td>
                <td>Keterangan</td>
                <td>Petugas</td>
            </tr>
            @forelse($data['penarikan'] as $penarikan)
            <tr align="center">
                <td>1</td>
                <td>{{ $penarikan->anggota }}</td>
                <td>{{ $penarikan->tanggal }}</td>
                <td>{{ $penarikan->jumlah }}</td>
                <td>{{ $penarikan->ket }}</td>
                <td>{{ $penarikan->petugas }}</td>
            </tr>
            @empty
                <tr align="center">
                    <td colspan="6">Tidak ada data</td>
                </tr>
            @endforelse

        </table>
</body>
</html>
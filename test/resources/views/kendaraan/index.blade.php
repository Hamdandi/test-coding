<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Kendaraan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="text-center">List Kendaraan</h1>
        {{-- <a href="{{ route('kendaraan.create') }}" class="btn btn-primary">Tambah Kendaraan</a> --}}
        <a href="#" class="btn btn-primary">Tambah Kendaraan</a>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kendaraan</th>
                        <th>Harga Sewa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kendaraan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kendaraan }}</td>
                            <td>{{ $item->harga_sewa }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

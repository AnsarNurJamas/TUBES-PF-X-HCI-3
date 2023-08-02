<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Penjualan</title>
    <style>
        html {
            font-size: 12px;
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 0.5rem;
            border: 1px solid black !important;
        }
    </style>
</head>
<body>
    <h1>DATA TRANSAKSI</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>NO</th>
                <th>KODE TRANSAKSI</th>
                <th>PELANGGAN</th>
                <th>TOTAL HARGA</th>
                <th>TANGGAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$item->transaction_code}}</td>
                    <td>{{$item->customer->name}}</td>
                    <td>{{$item->sub_total}}</td>
                    <td>{{$item->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

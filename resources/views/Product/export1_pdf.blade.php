<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Product</title>
    <style>
        html {
            font-size: 9px;
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
    <h1>Data Product</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>KODE PRODUK</th>
                <th>NAMA</th>
                <th>GAMBAR</th>
                <th>HARGA</th>
                <th>JUMLAH</th>
                <th>SATUAN</th>
                <th>STATUS</th>
                <th>CREATE AT</th>
                <th>UPDATE AT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product as $index => $product )
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{$product->kodeproduk}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->image}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->description}}</td>
                <td>
                    <span class="right badge badge-{{ $product->status ? 'success' : 'danger' }}">{{$product->status ? 'Ada' : 'Belum Ada'}}</span>
                </td>
                <td>{{$product->created_at}}</td>
                <td>{{$product->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
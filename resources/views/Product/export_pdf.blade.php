<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Produk</title>
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
                <th>HARGA BELI</th>
                <th>HARGA JUAL</th>
                <th>STOK</th>
                <th>DIBUAT PADA</th>
                <th>DI UPDATE PADA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($product as $index => $product )
            <tr>
                <td>{{$index + 1}}</td>
                <td>{{$product->product_code}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->purchase_price}}</td>
                <td>{{$product->selling_price}}</td>
                <td>{{$product->stock}}</td>
                <td>{{$product->created_at}}</td>
                <td>{{$product->updated_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

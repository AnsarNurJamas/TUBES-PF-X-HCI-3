<table>
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

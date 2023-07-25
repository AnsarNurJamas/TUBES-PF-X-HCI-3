<table>
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

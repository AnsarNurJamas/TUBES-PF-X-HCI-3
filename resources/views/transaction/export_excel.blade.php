<table>
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

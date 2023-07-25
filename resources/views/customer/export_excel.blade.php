<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Avatar</th>
            <th>Nama</th>
            <th>Email</th>
            <th>NO.Tel</th>
            <th>Alamat</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($customer as $index => $customer )
            <tr>
                <td>{{$index + 1}}</td>
                {{-- <td>{{$customer->id}}</td> --}}
                <td>
                
                    {{-- <img width="40px" class="img-thumbnail" src="{{$customer->getAvatarUrl()}}" alt=""> --}}
                </td>
                <td>{{$customer->first_name}}{{$customer->last_name}}</td>
                <td>{{$customer->email}}</td>
                <td>{{$customer->phone}}</td>
                <td>{{$customer->address}}</td>
                <td>{{$customer->created_at}}</td>
                <td>
        @endforeach
    </tbody>
</table>
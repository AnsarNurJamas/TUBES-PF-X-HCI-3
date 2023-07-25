<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Pelanggan</title>
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
    <h1>Data Pelanggan</h1>
    <table class="table table-bordered">
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
            @foreach ($customer as $index => $customer)
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
                    
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
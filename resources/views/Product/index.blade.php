@extends('layouts.app')
@section('content')
@push('scripts')
<script type="module">
    $(document).ready(function() {

        $(".datatable").on("click", ".btn-delete", function (e) {
            e.preventDefault();

            var form = $(this).closest("form");
            var name = $(this).data("name");

            Swal.fire({
                title: "Yakin Ingin Menghapus Produk\n" + name + "?",
                text: "Data Akan Terhapus",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: "bg-primary",
                confirmButtonText: "Yakin",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar bg-secondary navbar-dark">
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="" src="{{ Vite::asset('resources/images/LOGO.png') }}" alt="" style="width: 180px; height: 130px;">
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <a href="{{route('home')}}" class="nav-item nav-link"><i class="fa fa-tachometer-alt me-2"></i>Dasbor</a>
                    <a href="{{route('ProductCategories.index')}}" class="nav-item nav-link"><i class="fa fa-shopping-cart me-2"></i>Kategori Prduk</a>
                    <a href="{{route('Product.index')}}" class="nav-item nav-link active"><i class="fa fa-shopping-cart me-2"></i>Produk</a>
                    <a href="{{route('customer.index')}}" class="nav-item nav-link"><i class="fa fa-user-friends me-2"></i>Pelanggan</a>
                    <a href="{{ route('transaction.create', AppHelper::transaction_code())}}" class="nav-item nav-link"><i class="fa fa-cash-register me-2"></i>Transaksi</a>
                    <a href="{{route('transaction.index')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Penjualan</a>
                    <a href="{{ route('logout') }}" class="nav-item nav-link"><i class="fa fa-sign-out-alt me-2"
                     onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        </i>
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </nav>
        </div>
        <!-- Sidebar End -->


        <div class="content">
            <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-user-edit"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0">
                    <i class="fa fa-bars"></i>
                </a>
                <div class="navbar-nav align-items-center ms-auto me-3">
                    <div class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="rounded-circle me-lg-2 fa fa-user me-2"></i>
                            <span class="d-none d-lg-inline-flex">{{ Auth::user()->name }}</span>
                        </a>
                    </div>
                </div>
            </nav>

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h4 class="ms-4 mt-4">Manajemen Produk</h4>
                        <div class="ms-4 mt-4">
                            <ul class="list-inline mb-0 float-end">
                                <li class="list-inline-item">
                                    <a href="{{ route('Product.exportexcel')}}" class="btn btn-outline-success">
                                        <i class="bi bi-download me-1"></i> to Excel
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="{{ route('Product.export1Pdf') }}" class="btn btn-outline-danger">
                                        <i class="bi bi-download me-1"></i> to PDF
                                    </a>
                                </li>
                                <li class="list-inline-item">|</li>
                                <li class="list-inline-item">
                                    <a href="{{ route('Product.create') }}" class="me-4 btn btn-success">
                                        <i class="fas fa-plus"></i> Tambahkan Produk
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                        <!-- Recent Sales Start -->
                        <div class="container-fluid pt-2 px-2">
                            <div class="bg-secondary text-center rounded p-4">
                                <div class="table-responsive">
                                    <table class="table text-start align-middle table-bordered table-hover mb-0 datatable">
                                        <thead>
                                            <tr class="text-white">
                                                <th scope="col">ID</th>
                                                <th scope="col">GAMBAR</th>
                                                <th scope="col">KODE PRODUK</th>
                                                <th scope="col">NAMA PRODUK</th>
                                                <th scope="col">HARGA JUAL</th>
                                                <th scope="col">HARGA BELI</th>
                                                <th scope="col">STOK</th>
                                                <th scope="col">CREATE AT</th>
                                                <th scope="col">UPDATE AT</th>
                                                <th scope="col">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product as $product )
                                                <tr>
                                                    <td>{{ $product->id }}</td>
                                                    <td><img width="60px" height="20px" class="img-thumbnail" src="{{ Storage::url($product->image)}}" alt=""></td>
                                                    <td>{{ $product->product_code }}</td>
                                                    <td>{{ $product->name }}</td>
                                                    <td>{{ $product->selling_price }}</td>
                                                    <td>{{ $product->purchase_price}}</td>
                                                    <td>{{ $product->stock }}</td>
                                                    <td>{{ $product->created_at}}</td>
                                                    <td>{{ $product->updated_at}}</td>
                                                    <td>
                                                        <form action="{{ route('Product.destroy', $product) }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <a style="background-color: rgba(53, 142, 224, 1)" class="btn btn-sm btn-dark far fa-edit" href="{{route('Product.edit', $product)}}"></a>
                                                            <button type="submit" class="mx-3 btn btn-sm btn-primary btn-delete" data-name="{{ $product->kodeproduk.' '.$product->name }}">
                                                                <i class="bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
@endsection

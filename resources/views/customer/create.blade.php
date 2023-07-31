@extends('layouts.app')
@section('content')
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
                <a href="{{route('Product.index')}}" class="nav-item nav-link"><i class="fa fa-shopping-cart me-2"></i>Produk</a>
                <a href="{{route('customer.index')}}" class="nav-item nav-link active"><i class="fa fa-user-friends me-2"></i>Pelanggan</a>
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
        {{-- Title + Button  --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="ms-4 mt-4">Tambahkan Pelanggan</h4>
        </div>
        {{-- End Title + Button --}}

        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary rounded p-4">
                <form action="{{ route('customer.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="name" class="form-label">Nama Pelanggan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="Masukan Nama Belakang">
                            @error('name')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" placeholder="Masukan Email">
                            @error('email')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="phone_number" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ old('phone_number') }}" placeholder="Masukan Nomor Telepon">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label for="address" class="form-label">Alamat</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" id="address" value="{{ old('address') }}" placeholder="Masukan Alamat">
                            @error('address')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                            @enderror
                        </div>
                        <div class="col-md-6 d-grid">
                            <a href="{{route('customer.index')}}" class="btn btn-danger btn-lg mt-3">Batal Tambahkkan Pelanggan</a>
                        </div>
                        <div class="col-md-6 d-grid">
                            <button type="submit" class="btn btn-success btn-lg mt-3">Tambahkan Pelanggan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection

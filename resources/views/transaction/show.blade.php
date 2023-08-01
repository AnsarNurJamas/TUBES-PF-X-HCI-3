@extends('layouts.app')
@section('content')
@push('css')
<style>
    .tampil-bayar {
        font-size: 4em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #ffffff;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
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
                    <a href="{{route('Product.index')}}" class="nav-item nav-link"><i class="fa fa-shopping-cart me-2"></i>Produk</a>
                    <a href="{{route('customer.index')}}" class="nav-item nav-link"><i class="fa fa-user-friends me-2"></i>Pelanggan</a>
                    <a href="{{ route('transaction.create', AppHelper::transaction_code())}}" class="nav-item nav-link active"><i class="fa fa-cash-register me-2"></i>Transaksi</a>
                    <a href="{{route('transaction.index')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Penjualan</a>
                    <a href="{{route('company.index')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Profil</a>
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
                <h4 class="ms-4 mt-4">Transaksi Yang Sudah Dilakukan</h4>
            </div>

            <div class="container-fluid pt-2 px-2">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card bg-secondary">
                                <div class="card-header">
                                    Informasi
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="height:40px">
                                                    <i class="far fa-user"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control bg-dark" value="{{ $data['user'] }}" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="height:40px">
                                                    <i class="fas fa-key"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control bg-dark" value="{{ $transactionCode }}" name="transaction_code" readonly>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text" style="height:40px">
                                                    <i class="far fa-calendar-check"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control bg-dark" value="{{ \Carbon\Carbon::create($data['date'])->format('d/m/Y') }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg">
                            <div class="card card-block d-flex bg-secondary" style="height: 270px">
                                <div class="card-header">
                                    Rp.
                                </div>
                                <div class="card-body text-center align-items-center d-flex justify-content-center">
                                    <h1 class="display-1 priceDisplay">{{ number_format($subTotal, 0,',',',') }}</h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="bg-secondary card mt-3">
                    <div class="card-header">
                        Sales
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="saleTable">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Foto Produk</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Harga</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $index => $item)
                                    <tr>
                                        <th>{{ $index + 1 }}</th>
                                        <th>
                                            <img src="{{ Storage::disk('public')->exists($item->product->image) ? Storage::url($item->product->image) : url('assets/img/image_not_available.png') }}"
                                            alt="Foto Produk" class="img-fluid rounded mt-1 mb-1" height="10px" width="80px" />
                                        </th>
                                        <th>{{ $item->product->name }}</th>
                                        <th>Rp. {{ number_format($item->product_price, 0,',',',') }}</th>
                                        <th>{{ $item->quantity }}</th>
                                        <th>Rp. {{ number_format($item->total_price, 0,',',',') }}</th>
                                    </tr>
                                  @empty
                                    <tr>
                                        <td colspan="7" class="text-center">
                                            Belum ada produk yang dibeli.
                                        </td>
                                    </tr>
                                  @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-3">
                        <form action="{{route('transaction.store')}}" method="post">
                            @csrf
                            <input type="hidden" name="transaction_code" value="{{ $transactionCode}}" />
                            <div class="bg-secondary card" style="height: 150px">
                                <div class="card-header">Pelanggan</div>
                                    <div class="card-body">
                                        <div class="form-group col-lg-12">
                                            <label>Pilih nama Pelanggan</label><br>
                                            <select name="customer_id" class="custom-select col-lg-12 mt-3 bg-dark" style="color:white;" disabled>
                                                @foreach ($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $data['customerId'] == $customer->id ? 'selected' : ''}}>
                                                    {{ $customer->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <div class="col-lg">
                        <div class="card bg-secondary" style="height: 150px">
                            <div class="card-header">Pembayaran</div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Sub Total</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="text" name="sub_total" class="form-control currency bg-dark" value="{{ $subTotal }}" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Dibayar</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="text" name="paid" class="form-control currency bg-dark" value="{{ $data['paid'] }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>Kembalian</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Rp.</div>
                                                    </div>
                                                    <input type="text" name="change" class="form-control currency bg-dark" value="{{ $data['change'] }}" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
        </div>
    </div>
</div>
@foreach ($items as $item)
<div class="modal fade" tabindex="-1" role="dialog" id="editItem-{{ $item->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('sale.update', $item->id) }}" method="POST">
                @method('PUT')
                @csrf
                <input type="hidden" name="transaction_code" value="{{ $item->transaction_code }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $item->product->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kode Produk</label>
                        <input type="text" class="form-control" value="{{ $item->product->product_code }}" readonly />
                    </div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" value="{{ $item->quantity }}" required />
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endforeach
@endsection

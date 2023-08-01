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
                    <a href="{{route('Product.index')}}" class="nav-item nav-link"><i class="fa fa-shopping-cart me-2"></i>Produk</a>
                    <a href="{{route('customer.index')}}" class="nav-item nav-link"><i class="fa fa-user-friends me-2"></i>Pelanggan</a>
                    <a href="{{ route('transaction.create', AppHelper::transaction_code())}}" class="nav-item nav-link"><i class="fa fa-cash-register me-2"></i>Transaksi</a>
                    <a href="{{route('transaction.index')}}" class="nav-item nav-link"><i class="fa fa-chart-bar me-2"></i>Penjualan</a>
                    <a href="{{route('company.index')}}" class="nav-item nav-link active"><i class="fa fa-chart-bar me-2"></i>Profil</a>
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
                        <h4 class="ms-4 mt-4">Profil Toko</h4>
                    </div>

                        <!-- Recent Sales Start -->
                        <div class="container-fluid pt-2 px-2">
                            <div class="bg-secondary rounded p-4">
                                <form action="{{ route('CompanyProfile.save', $item) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label for="">Pratinjau Foto</label>
                                                    <img src="{{ !is_null($item) ? Storage::url($item->image) : url('assets/img/image_not_available.png') }}"
                                                    class="rounded img-responsive" alt="{{ !is_null($item) ? $item->name : 'Company image' }}" width="100%" id="img-preview">
                                                </div>
                                                <div class="form-group">
                                                    <label class="float-right">
                                                        <a href="#" data-toggle="tooltip" title="Klik untuk menghapus foto yang sudah dipilih" style="display:none" id="img-reset">
                                                            <code class="text-right">Hapus Foto</code>
                                                        </a>
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            {{-- <div class="input-group-text">
                                                                <i class="fas fa-file-image"></i>
                                                            </div> --}}
                                                        </div>
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input " name="image" id="img-file">
                                                            <label class="custom-file-label" id="img-name"></label>
                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg">
                                                <div class="form-group">
                                                    <label>Nama</label>
                                                    <input type="text" class="form-control" name="name" value="{{ !is_null($item) ? $item->name : old('name') }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Alamat</label>
                                                    <textarea style="height: 50px" name="address" cols="30" rows="10" class="form-control">{{ !is_null($item) ? $item->address : old('address') }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>Contact</label>
                                                    <textarea style="height: 50px" name="contact" cols="30" rows="10" class="form-control">{{ !is_null($item) ? $item->contact : old('contact') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-grid gap-2 d-md-flex justify-content-md-end"">
                                        <button type="submit" class="btn btn-primary me-md-2">Simpan</button>
                                    </div>
                                </form>  
                            </div>
                        </div>

@endsection

@extends('user/template/layout')

@section('content')

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Cari Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Cari Booking</li>
            </ol>
        </nav>
    </div>

    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('user.search')}}" method="POST" enctype="multipart/form-data" id="bookingForm">
                        @csrf
                        <h5 class="card-title">Booking</h5>
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
                                <button class="btn btn-primary" type="button"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>


</main>
@endsection
@extends('user/template/layout')

@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Cari Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Cari Booking</li>
            </ol>
        </nav>
    </div>

    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.search') }}" method="POST" enctype="multipart/form-data" id="bookingForm">
                        @csrf
                        <h5 class="card-title">Cari Booking</h5>
                        <div class="mb-3">
                            <label class="form-label">Kode Booking</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Masukkan kode booking..." value="{{$kode_booking ? $kode_booking : ''}}" required>
                                <button class="btn btn-primary" type="submit"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>

    @if (isset($dataBooking))
    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Data Booking</h5>
                    <div class="row mb-3">
                        <label for="ruang" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $dataBooking->nama }}" type="text" class="form-control" id="nama" name="nama">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="ruang" class="col-sm-2 col-form-label">Agenda</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $dataBooking->agenda_rapat }}" type="text" class="form-control" id="agenda" name="agenda">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="ruang" class="col-sm-2 col-form-label">Ruangan</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $dataBooking->ruang->ruang }}" type="text" class="form-control" id="ruang" name="ruang">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $dataBooking->ruang->lokasi }}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="kampus">Hari/Tanggal</label>
                        <div class="col-sm-10">
                            <input disabled value="{{ $dataBooking->tanggal }}" type="text" class="form-control" id="tanggal" name="tanggal" maxlength="100">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="kampus">Waktu</label>
                        <div class="col-sm-10">
                            @switch($dataBooking->kode_waktu)
                                @case(1)
                                    <input disabled value="Pagi - Siang" type="text" class="form-control" id="waktu" name="waktu" maxlength="100">
                                    @break
                                @case(2)
                                    <input disabled value="Siang - Sore" type="text" class="form-control" id="waktu" name="waktu" maxlength="100">
                                    @break
                                @case(3)
                                    <input disabled value="Pagi - Siang" type="text" class="form-control" id="waktu" name="waktu" maxlength="100">
                                    @break
                                @default
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</main>

@endsection
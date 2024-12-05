@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Daftar Booking</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">{{$page_title}}</h5>
                            <a href="{{route('admin.booking.list')}}">
                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-back"></i> Kembali</button>
                            </a>
                        </div>

                        <div class="row mb-3">
                            <label for="ruang" class="col-sm-2 col-form-label">Kode Booking</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->kode}}" type="text" class="form-control" id="ruang" name="ruang">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->nama}}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gedung" class="col-sm-2 col-form-label">No HP</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->no_hp}}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kampus">Agenda Rapat</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->agenda_rapat}}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kampus">Tanggal</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->tanggal}}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kampus">Waktu Booking</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$waktu}}" type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kampus">File</label>
                            <div class="col-sm-10">
                                <a href="{{url('/files/'.$detail->file)}}" id="lokasi" name="lokasi" target="_blank">{{$detail->file}}</a>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
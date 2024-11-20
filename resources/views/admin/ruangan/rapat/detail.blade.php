@extends('admin/template/layout')

@section('content')

@php
@$day = explode(',', $ruang->day_available);
@$time = explode(',', $ruang->time_available);
@$foto = explode(',', $ruang->foto);
@endphp
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Data Ruangan</li>
                <li class="breadcrumb-item"><a href="{{route('admin.data-ruangan.rapat.index')}}">R. Rapat</a></li>
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
                            <a href="{{route('admin.data-ruangan.rapat.index')}}">
                                <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-back"></i> Kembali</button>
                            </a>
                        </div>

                        <div class="row mb-3">
                            <label for="ruang" class="col-sm-2 col-form-label">Nama Ruangan</label>
                            <div class="col-sm-10">
                                <input disabled type="text" class="form-control" id="ruang" name="ruang" value="{{$ruang->ruang}}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-10">
                                <input disabled type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100" value="{{$ruang->lokasi}}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gedung" class="col-sm-2 col-form-label">Lokasi Gedung</label>
                            <div class="col-sm-10">
                                <select disabled class="form-select" name="gedung" id="gedung" required>
                                    <option value="" hidden>Pilih Gedung</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="kampus">Lokasi Kampus</label>
                            <div class="col-sm-10">
                                <select disabled class="form-select" name="kampus" id="kampus" required>
                                    <option value="" hidden>Pilih Kampus</option>
                                    <option value="1" {{$ruang->kampus == '1' ? 'selected' : ''}}>Kampus 1</option>
                                    <option value="2" {{$ruang->kampus == '2' ? 'selected' : ''}}>Kampus 2</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-12 col-md-2 col-form-label">Hari Tersedia</label>
                            <div class="col-sm-12 col-md-4">
                                <div class="row">
                                    @foreach($day as $d)
                                    <div class="col-sm-12 col-md-4">
                                        <ul>
                                            <li>{{$d}}</li>
                                        </ul>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                        <label class="col-sm-12 col-md-2 col-form-label">Waktu Tersedia</label>
                            <div class="col-sm-12 col-md-4">
                                <div class="row">
                                    @foreach($time as $t)
                                        @switch($t)
                                            @case('1')
                                                <div class="col-sm-12 col-md-12">
                                                    <ul>
                                                        <li>Pagi - Siang</li>
                                                    </ul>
                                                </div>
                                                @break
                                            @case('2')
                                                <div class="col-sm-12 col-md-12">
                                                    <ul>
                                                        <li>Siang - Sore</li>
                                                    </ul>
                                                </div>
                                                @break
                                            @case('3')
                                                <div class="col-sm-12 col-md-12">
                                                    <ul>
                                                        <li>Pagi - Sore</li>
                                                    </ul>
                                                </div>
                                                @break
                                        @endswitch
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        @push('styles')
                        <style>
                            .img-container {
                                position: relative;
                                text-align: center;
                                color: white;
                            }

                            .top-right {
                                position: absolute;
                                top: 8px;
                                right: 16px;
                            }
                        </style>
                        @endpush

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Foto Ruangan</label>
                            <div class="col-sm-10">
                                <div class="row mt-2">
                                    @foreach($foto as $f)
                                    <div class="col-sm-12 col-md-4 col-lg-2 mb-3 p-2">
                                        <div class="img-container">
                                            <img src="{{url('images/'.$f)}}" alt="{{$f}}" style="max-width:95%;">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
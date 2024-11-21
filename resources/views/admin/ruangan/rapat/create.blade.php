@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Data Ruangan</li>
                <li class="breadcrumb-item">R. Rapat</li>
                <li class="breadcrumb-item active"><a href="">Create</a></li>
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

                        <form action="{{route('admin.data-ruangan.rapat.store')}}" method="post" enctype="multipart/form-data" id="addForm">
                            @csrf
                            <div class="row mb-3">
                                <label for="ruang" class="col-sm-2 col-form-label">Nama Ruangan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="ruang" name="ruang" placeholder="Nama Ruangan" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100" placeholder="Lokasi Ruangan" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gedung" class="col-sm-2 col-form-label">Lokasi Gedung</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="gedung" id="gedung">
                                        <option value="" hidden>Pilih Gedung</option>
                                        @foreach($data_gedung as $gg)
                                        <option value="{{$gg->id}}">{{$gg->gedung}} (Kampus {{$gg->kampus}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kampus">Lokasi Kampus</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="kampus" id="kampus" required>
                                        <option value="" hidden>Pilih Kampus</option>
                                        <option value="1">Kampus 1</option>
                                        <option value="2">Kampus 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Hari Tersedia</label>
                                <div class="col-sm-3">
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="senin" value="Senin" name="hari[]">
                                            <label class="form-check-label" for="senin">Senin</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selasa" value="Selasa" name="hari[]">
                                            <label class="form-check-label" for="selasa">Selasa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rabu" value="Rabu" name="hari[]">
                                            <label class="form-check-label" for="rabu">Rabu</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="kamis" value="Kamis" name="hari[]">
                                            <label class="form-check-label" for="kamis">Kamis</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="jumat" value="Jumat" name="hari[]">
                                            <label class="form-check-label" for="jumat">Jumat</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sabtu" value="Sabtu" name="hari[]">
                                            <label class="form-check-label" for="sabtu">Sabtu</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="minggu" value="Minggu" name="hari[]">
                                            <label class="form-check-label" for="minggu">Minggu</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Waktu Tersedia</label>
                                <div class="col-sm-3">
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="pagi-siang" value="1" name="waktu[]">
                                            <label class="form-check-label" for="pagi-siang">Pagi - Siang</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="siang-sore" value="2" name="waktu[]">
                                            <label class="form-check-label" for="siang-sore">Siang - Sore</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="pagi-sore" value="3" name="waktu[]">
                                            <label class="form-check-label" for="pagi-sore">Pagi - Sore</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <livewire:foto-upload />
                        </form>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end align-items-end">
                            <button type="submit" form="addForm" class="btn btn-outline-primary btn-sm">Tambah</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
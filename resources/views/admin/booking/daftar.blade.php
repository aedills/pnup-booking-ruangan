@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Daftar Booking</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Pending Booking</h5>
                        </div>
                        <!-- Tabel -->
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nama Gedung</th>
                                        <th scope="col">Nama Ruangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Rifqi</td>
                                        <td>Gedung AD</td>
                                        <td>bang acc punyaku plis</td>
                                        <td>
                                            <button class="btn btn-outline-danger"> Tolak</button>
                                            <button class="btn btn-outline-success"> Terima</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Confirmed Booking</h5>
                        </div>
                        <!-- Tabel -->
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nama Gedung</th>
                                        <th scope="col">Nama Ruangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                    <tr>
                                        <td>1</td>
                                        <td>Rifqi</td>
                                        <td>Gedung AD</td>
                                        <td>makasih udah di acc bang</td>
                                        <td>
                                            <button class="btn btn-outline-info"> akshit</button>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Modal Section -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.gedung.store')}}" method="post" enctype="multipart/form-data" id="addForm">
                        @csrf
                        <div class="row mb-3">
                            <label for="gedung" class="col-sm-3 col-form-label">Nama Gedung</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="gedung" name="gedung" placeholder="Nama Gedung" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="kampus">Lokasi Kampus</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="kampus" id="kampus" required>
                                    <option value="" hidden>Pilih Kampus</option>
                                    <option value="1">Kampus 1</option>
                                    <option value="2">Kampus 2</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="addForm" class="btn btn-sm btn-outline-primary">Tambah</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Gedung</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.gedung.update')}}" method="post" enctype="multipart/form-data" id="editForm">
                        @csrf
                        <input type="text" name="uuid" value="" hidden>
                        <div class="row mb-3">
                            <label for="gedung" class="col-sm-3 col-form-label">Nama Gedung</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="gedung" name="gedung" value="" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label" for="kampus">Lokasi Kampus</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="kampus" id="kampus" required>
                                    <option value="" hidden>Pilih Kampus</option>
                                    <option value="1">Kampus 1</option>
                                    <option value="2">Kampus 2</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="editForm" class="btn btn-sm btn-outline-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection
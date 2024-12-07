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
                <li class="breadcrumb-item active">Edit</li>
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

                        <form action="{{route('admin.data-ruangan.rapat.update')}}" method="post" enctype="multipart/form-data" id="editForm">
                            @csrf
                            <input type="text" name="id" id="id" value="{{$ruang->id}}" hidden>
                            <input type="text" name="uuid" id="uuid" value="{{$ruang->uuid}}" hidden>
                            <div class="row mb-3">
                                <label for="ruang" class="col-sm-2 col-form-label">Nama Ruangan</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="ruang" name="ruang" value="{{$ruang->ruang}}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="lokasi" class="col-sm-2 col-form-label">Lokasi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="lokasi" name="lokasi" maxlength="100" value="{{$ruang->lokasi}}" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="gedung" class="col-sm-2 col-form-label">Lokasi Gedung</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="gedung" id="gedung" required>
                                        <option value="" hidden>Pilih Gedung</option>
                                        @foreach($data_gedung as $gg)
                                        <option value="{{$gg->id}}" {{$gg->id == $ruang->id_gedung ? 'selected' : ''}}>{{$gg->gedung}} (Kampus {{$gg->kampus}})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="kampus">Lokasi Kampus</label>
                                <div class="col-sm-10">
                                    <select class="form-select" name="kampus" id="kampus" required>
                                        <option value="" hidden>Pilih Kampus</option>
                                        <option value="1" {{$ruang->kampus == '1' ? 'selected' : ''}}>Kampus 1</option>
                                        <option value="2" {{$ruang->kampus == '2' ? 'selected' : ''}}>Kampus 2</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Hari Tersedia</label>
                                <div class="col-sm-3">
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="senin" value="Senin" name="hari[]" {{in_array('Senin', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="senin">Senin</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selasa" value="Selasa" name="hari[]" {{in_array('Selasa', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="selasa">Selasa</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rabu" value="Rabu" name="hari[]" {{in_array('Rabu', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="rabu">Rabu</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="kamis" value="Kamis" name="hari[]" {{in_array('Kamis', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="kamis">Kamis</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="jumat" value="Jumat" name="hari[]" {{in_array('Jumat', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="jumat">Jumat</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="sabtu" value="Sabtu" name="hari[]" {{in_array('Sabtu', $day) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="sabtu">Sabtu</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="minggu" value="Minggu" name="hari[]" {{in_array('Minggu', $day) ? 'checked' : ''}}>
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
                                            <input class="form-check-input" type="checkbox" id="pagi-siang" value="1" name="waktu[]" {{in_array('1', $time) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="pagi-siang">Pagi - Siang</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="siang-sore" value="2" name="waktu[]" {{in_array('2', $time) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="siang-sore">Siang - Sore</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="pagi-sore" value="3" name="waktu[]" {{in_array('3', $time) ? 'checked' : ''}}>
                                            <label class="form-check-label" for="pagi-sore">Pagi - Sore</label>
                                        </div>
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
                                <div class="col-sm-10 offset-sm-2">
                                    <div class="row mt-2">
                                        @foreach($foto as $f)
                                        <div class="col-sm-12 col-md-4 col-lg-2 mb-3 p-1">
                                            <div class="img-container">
                                                <img src="{{url('images/'.$f)}}" alt="{{$f}}" style="max-width:95%;">
                                                <div class="top-right"><button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteImage('{{route('admin.data-ruangan.rapat.deleteFoto', ['id' => $ruang->id, 'foto' => $f])}}')">Hapus</button></div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <livewire:addition-foto-upload />
                        </form>

                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end align-items-end">
                            <button type="submit" form="editForm" class="btn btn-outline-primary btn-sm">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
    <script>
        function deleteImage(url) {
            Swal.fire({
                title: 'Hapus foto tersebut?',
                text: "Foto yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete request
                    fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    }).then(response => {
                        if (response.ok) {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "success",
                                title: "Berhasil menghapus foto",
                                showConfirmButton: false,
                                timer: 2500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "error",
                                title: "Gagal menghapus foto",
                                showConfirmButton: false,
                                timer: 2500
                            });
                        }
                    }).catch(error => {
                        Swal.fire(
                            'Error!',
                            'There was a problem deleting the item.',
                            'error'
                        );
                    });
                }
            });
        }
    </script>
    @endpush
</main>

@endsection
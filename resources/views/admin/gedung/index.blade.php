@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Data Gedung</li>
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
                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal"><i class="fa-solid fa-plus"></i> Tambah</button>
                        </div>

                        <!-- Tabel -->
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Nama Gedung</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($datagedung as $list)
                                    <tr>
                                        <td scope="row">{{$loop->iteration}}</td>
                                        <td>{{$list->gedung}} (Kampus {{$list->kampus}})</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-uuid="{{$list->uuid}}" data-bs-gedung="{{$list->gedung}}" data-bs-kampus="{{$list->kampus}}" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fa-solid fa-pencil"></i> Edit</button>
                                            <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('admin.gedung.delete', ['uuid' => $list->uuid]) }}')"><i class="fa-solid fa-trash"></i> Hapus</button>

                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada Data</td>
                                    </tr>
                                    @endforelse
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


    @push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('show.bs.modal', '#editModal', function(event) {
                var button = $(event.relatedTarget);

                var uuid = button.data('bs-uuid');
                var gedung = button.data('bs-gedung');
                var kampus = button.data('bs-kampus');

                $(this).find('input[name="uuid"]').val(uuid);
                $(this).find('input[name="gedung"]').val(gedung);
                $(this).find('select[name="kampus"]').val(kampus);
            });
        });

        function confirmDelete(deleteUrl) {
            Swal.fire({
                title: 'Hapus data tersebut?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
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
                                title: "Berhasil menghapus data",
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                toast: true,
                                position: "top-end",
                                icon: "error",
                                title: "Gagal menghapus data",
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
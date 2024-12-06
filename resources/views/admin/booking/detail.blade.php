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
                            <label class="col-sm-2 col-form-label">Kode Booking</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->kode}}" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->nama}}" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">No HP</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->no_hp}}" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Agenda Rapat</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->agenda_rapat}}" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Ruangan</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->ruang->ruang}}" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Lokasi</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->ruang->lokasi}}" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$detail->tanggal}}" type="text" class="form-control">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label">Waktu Booking</label>
                            <div class="col-sm-10">
                                <input disabled value="{{$waktu}}" type="text" class="form-control">
                            </div>
                        </div>

                        @if($detail->file)
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">File</label>
                                <div class="col-sm-10">
                                    <a href="{{url('/files/'.$detail->file)}}" target="_blank"><i class="fa-regular fa-file"></i> {{$detail->file}}</a>
                                </div>                            
                            </div>
                        @endif
                    </div>
                    @if($detail->status == 'none')
                        <div class="card-footer">
                            <div class="d-flex justify-content-end align-item-center gap-1">
                                <button type="button" class="btn btn-sm btn-outline-success" onclick="accept('{{$detail->uuid}}')">Terima</button>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="decline('{{$detail->uuid}}')">Tolak</button>
                                <a href="{{route('admin.booking.list')}}">
                                    <button class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-back"></i> Kembali</button>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <script>
        // accept
        function accept(uuid) {
            Swal.fire({
                title: 'Konfirmasi Permintaan Booking?',
                text: 'Permintaan lain di waktu dan ruangan yang sama akan ditolak.',
                icon: 'success',
                showCancelButton: true,
                confirmButtonText: 'Ya, Konfirmasi',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-sm btn-outline-success',
                    cancelButton: 'btn btn-sm btn-outline-secondary'
                },
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{route('admin.booking.accept')}}";

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // accept request
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                uuid: uuid
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Permintaan berhasil dikonfirmasi.',
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-outline-success',
                                    },
                                    timer: 4000,
                                    allowOutsideClick: false
                                }).then(() => {
                                    location.reload();
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 4000);
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat memproses permintaan.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-outline-danger',
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            // Handle fetch error
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan koneksi.',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-outline-danger',
                                }
                            });
                        });
                }
            });
        }

        // decline
        function decline(uuid) {
            Swal.fire({
                title: 'Tolak Permintaan Booking?',
                text: 'Permintaan yang ditolak tidak akan bisa dikembalikan.',
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Pesan ...',
                showCancelButton: true,
                confirmButtonText: 'Tolak Permintaan',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-sm btn-outline-danger',
                    cancelButton: 'btn btn-sm btn-outline-secondary'
                },
                allowOutsideClick: false,
                didOpen: () => {
                    const textarea = Swal.getInput();
                    if (textarea) {
                        textarea.setAttribute('rows', '3');
                        textarea.style.height = 'auto';
                        textarea.style.overflowY = 'auto';
                    }
                },
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Anda harus membarikan alasan penolakan.');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{route('admin.booking.decline')}}";

                    Swal.fire({
                        title: 'Memproses...',
                        text: 'Mohon tunggu.',
                        icon: 'info',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // decline request
                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                uuid: uuid,
                                pesan: result.value
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success message
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'Permintaan berhasil ditolak.',
                                    icon: 'success',
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-outline-success',
                                    },
                                    timer: 4000,
                                    allowOutsideClick: false
                                }).then(() => {
                                    location.reload();
                                });

                                setTimeout(() => {
                                    location.reload();
                                }, 4000);
                            } else {
                                Swal.fire({
                                    title: 'Gagal!',
                                    text: 'Terjadi kesalahan saat memproses permintaan.',
                                    icon: 'error',
                                    confirmButtonText: 'Ok',
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-outline-danger',
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            // Handle fetch error
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan koneksi.',
                                icon: 'error',
                                confirmButtonText: 'Ok',
                                customClass: {
                                    confirmButton: 'btn btn-sm btn-outline-danger',
                                }
                            });
                        });
                }
            });

        }
    </script>
</main>

@endsection
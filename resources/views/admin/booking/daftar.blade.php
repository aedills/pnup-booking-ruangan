@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{ $page_title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                                        <th scope="col">Kode Booking</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Ruangan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pending as $pend)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pend->kode }}</td>
                                        <td>{{ $pend->nama }}</td>
                                        <td>{{ $pend->ruang->ruang }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pend->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td>
                                            @switch($pend->kode_waktu)
                                            @case(1)
                                            Pagi - Siang
                                            @break

                                            @case(2)
                                            Siang - Sore
                                            @break

                                            @case(3)
                                            Pagi - Sore
                                            @break

                                            @default
                                            @endswitch
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start align-item-center gap-1">
                                                <a href="{{route('admin.booking.detail', ['uuid' => $pend->uuid])}}">
                                                    <button type="button" class="btn btn-sm btn-outline-info">Detail</button>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-success" onclick="accept('{{$pend->uuid}}')">Terima</button>
                                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="decline('{{$pend->uuid}}')">Tolak</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
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
                                        <th scope="col">Kode Booking</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Ruangan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($accept as $acc)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $acc->kode }}</td>
                                        <td>{{ $acc->nama }}</td>
                                        <td>{{ $acc->ruang->ruang }}</td>
                                        <td>{{ \Carbon\Carbon::parse($acc->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}
                                        </td>
                                        <td>
                                            @switch($acc->kode_waktu)
                                            @case(1)
                                            Pagi - Siang
                                            @break

                                            @case(2)
                                            Siang - Sore
                                            @break

                                            @case(3)
                                            Pagi - Sore
                                            @break

                                            @default
                                            @endswitch
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="cancelAcc('{{$acc->uuid}}')">Batal Konfirmasi</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Declined Booking</h5>
                        </div>
                        <!-- Tabel -->
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Kode Booking</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Ruangan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($decline as $dec)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dec->kode }}</td>
                                        <td>{{ $dec->nama }}</td>
                                        <td>{{ $dec->ruang->ruang }}</td>
                                        <td>{{ \Carbon\Carbon::parse($dec->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                        <td>
                                            @switch($dec->kode_waktu)
                                            @case(1)
                                            Pagi - Siang
                                            @break

                                            @case(2)
                                            Siang - Sore
                                            @break

                                            @case(3)
                                            Pagi - Sore
                                            @break

                                            @default
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{route('admin.booking.detail', ['uuid' => $dec->uuid])}}">
                                                <button type="button" class="btn btn-sm btn-outline-info">Detail</button>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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

        // cancel
        function cancelAcc(uuid) {
            console.log(uuid);
            Swal.fire({
                title: 'Batalkan Konfirmasi Booking?',
                text: 'Permintaan yang telah dibatalkan tidak akan bisa dikembalikan.',
                icon: 'warning',
                input: 'textarea',
                inputPlaceholder: 'Pesan pembatalan',
                showCancelButton: true,
                confirmButtonText: 'Batalkan Booking',
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
                        Swal.showValidationMessage('Anda harus membarikan alasan pembatalan.');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{route('admin.booking.cancel')}}";

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
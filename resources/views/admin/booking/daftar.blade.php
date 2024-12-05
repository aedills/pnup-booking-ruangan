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
                                            <div class="d-flex justify-content-center align-item-center gap-1">
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
                                            <button type="button" class="btn btn-sm btn-outline-info">Detail</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div>
                                <script>
                                    $(document).ready(function() {
                                        $('#TolakModal').on('show.bs.modal', function(event) {
                                            var button = $(event.relatedTarget);
                                            var uuid = button.data('bs-uuid');
                                            $(this).find('input[name="uuid"]').val(uuid);
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                        <!-- Modal Terima-->
                        <div class="modal fade" id="TerimaModal" tabindex="-1" aria-labelledby="TerimaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TerimaModalLabel">Konfirmasi Booking</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda ingin menerima booking ini?<br>Permintaan booking di waktu dan ruang yang sama akan ditolak. Anda masih dapat membatalkan konfirmasi booking ini nanti.</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="button" class="btn btn-success">Terima</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Tolak-->
                        <div class="modal fade" id="TolakModal" tabindex="-1" aria-labelledby="TolakModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="TolakModalLabel">Tolak Permintaan Booking?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Permintaan booking yang ditolak tidak akan bisa dikembalikan.</p>
                                        <form id="declineform" action="{{ route('admin.booking.decline')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" name="uuid" value="" hidden>
                                            <div class="mb-3">
                                                <textarea name="pesan" class="form-control" id="exampleTextarea" rows="3" placeholder="Pesan..."></textarea>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-danger" form="declineform">Tolak</button>
                                    </div>
                                </div>
                            </div>
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
    </script>

</main>
@endsection
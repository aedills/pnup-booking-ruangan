@extends('user/template/layout')

@section('content')

@php
$waktuTersedia = explode(',', $data->time_available);
@endphp

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Dashboard</a></li>
                <li class="breadcrumb-item active">Booking</li>
            </ol>
        </nav>
    </div>

    <section class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        Booking {{$data->ruang}}
                    </h5>
                    <form action="{{route('user.booking', ['uuid' => $data->uuid])}}" method="POST" enctype="multipart/form-data" id="bookingForm">
                        @csrf
                        <input type="text" value="{{ $data->uuid }}" hidden>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" placeholder="Contoh: 6285xxxxxxxxx" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Agenda Rapat</label>
                            <textarea class="form-control" id="nama_rapat" name="nama_rapat" required placeholder="Agenda Rapat"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Pesan</label>
                            <textarea class="form-control" id="pesan" name="pesan" rows="4" placeholder="Pesan yang ingin Anda sampikan kepada petugas ruangan"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <input value="{{$date ? $date : ''}}" type="text" class="form-control" id="tanggal" name="tanggal_booking" required oninput="checkTime(this.value, '{{$data->uuid}}')">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu</label>
                            <select class="form-select" name="waktu" id="waktu" disabled>
                                <option hidden value="">Pilih tanggal terlebih dahulu</option>
                                @foreach ($waktuTersedia as $waktu)
                                    @switch($waktu)
                                        @case(1)
                                            <option value="{{ $waktu }}">Pagi - Siang</option>
                                            @break
                                        @case(2)
                                            <option value="{{ $waktu }}">Siang - Sore</option>
                                            @break
                                        @case(3)
                                            <option value="{{ $waktu }}">Pagi - Sore</option>
                                            @break
                                        @default
                                    @endswitch
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Berkas (<strong><i>Opsional</i></strong>)</label>
                            <input class="form-control" type="file" id="file" name="file"></input>
                        </div>

                        <div style="display: none;" id="status">
                            <h6 class="text-danger">Ruangan telah dibooking penuh pada tanggal tersebut</h6>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{route('user.index')}}">
                                <button type="button" class="btn btn-outline-secondary btn-sm">Kembali</button>
                            </a>
                            <button type="submit" class="btn btn-outline-primary btn-sm">Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function checkTime(date, uuid) {
            // console.log(date);
            // console.log(uuid);

            // Perform an AJAX request using jQuery
            $.ajax({
                url: "{{ route('user.checkAvailability') }}",
                type: 'POST',
                data: {
                    date: date,
                    uuid: uuid,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    // console.log(response);

                    const $waktuDropdown = $('#waktu');
                    const $statusWaktu = $('#status');
                    $waktuDropdown.empty();
                    $waktuDropdown.append('<option hidden value="">Pilih waktu tersedia</option>');
                    if (response.data.length > 0) {
                        response.data.forEach(function(item) {
                            switch (item) {
                                case 1:
                                    $waktuDropdown.append('<option value="1">Pagi - Siang</option>');
                                    break;
                                case 2:
                                    $waktuDropdown.append('<option value="2">Siang - Sore</option>');
                                    break;
                                case 3:
                                    $waktuDropdown.append('<option value="3">Pagi - Sore</option>');
                                    break;
                            }
                        });
                        $('#status').css('display', 'none');
                        $waktuDropdown.prop('disabled', false);
                    } else {
                        $waktuDropdown.prop('disabled', true);
                        $waktuDropdown.empty();
                        $waktuDropdown.append('<option hidden value="">Pilih tanggal terlebih dahulu</option>');
                        $('#status').css('display', 'block');
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        }

        // Attach the function to the input's oninput event
        $('#tanggal').on('input', function() {
            const date = $(this).val(); // Get the date value
            const uuid = '{{ $data->uuid }}'; // Use the UUID directly from Blade
            checkTime(date, uuid);
        });

        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            Swal.fire({
                title: 'Memproses....',
                text: 'Harap tunggu hingga proses booking selesai!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });

        checkTime("{{$date}}", "{{$data->uuid}}");
    </script>


</main>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    const tanggalDibolehkan = "{{ $data->day_available }}".split(',');
    const mapHari = {
        'Minggu': 0,
        'Senin': 1,
        'Selasa': 2,
        'Rabu': 3,
        'Kamis': 4,
        'Jumat': 5,
        'Sabtu': 6
    }

    const tanggalTidakDibolehkan = [0, 1, 2, 3, 4, 5, 6].filter(day =>
        !tanggalDibolehkan.includes(Object.keys(mapHari).find(key => mapHari[key] === day))
    );

    flatpickr('#tanggal', {
        disable: [
            function(date) {
                return tanggalTidakDibolehkan.includes(date.getDay());
            }
        ],
        dateFormat: 'd-m-Y',
        minDate: 'today'
    });

    // document.querySelector('#tanggal').addEventListener('change', function(e) {
    //     console.log(e.target.value);
    // })
</script>

@endsection
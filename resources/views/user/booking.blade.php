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
                    <form action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="text" value="{{ $data->uuid }}" hidden>

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">No. HP</label>
                            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Rapat</label>
                            <textarea class="form-control" id="nama_rapat" name="nama_rapat" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-calendar"></i>
                                </span>
                                <input type="text" class="form-control" id="tanggal" name="tanggal" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Waktu</label>
                            <select class="form-select" name="waktu" id="waktu">
                                <option selected disabled>Silahkan pilih waktu</option>
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

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-primary">Booking</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
            function(date){
                return tanggalTidakDibolehkan.includes(date.getDay());
            }
        ],
        dateFormat: 'd-m-Y',
        minDate: 'today'
    });

    document.querySelector('#tanggal').addEventListener('change', function(e){
        console.log(e.target.value);
    })
</script>


@endsection
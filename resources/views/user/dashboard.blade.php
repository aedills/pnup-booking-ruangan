@extends('user/template/layout')

@push('styles')
<style>
    .card .row {
        min-height: 100%;
    }

    .col-md-4 {
        display: flex;
    }

    #roomCarousel {
        flex: 1;
    }

    .carousel-item {
        height: 100%;
    }

    .carousel-item img,
    .without-carousel img {
        object-fit: cover;
        object-position: center;
        width: 100%;
        height: 100%;
    }

    #roomCarousel,
    .carousel-inner {
        height: 100%;
    }
</style>
@endpush

@section('content')

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Daftar Ruangan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Daftar Ruangan</li>
            </ol>
        </nav>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tersedia</h5>
                    <div class="mb-4">
                        <label class="form-label">Sesuaikan Tanggal</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-calendar"></i>
                            </span>
                            <input type="text" class="form-control" id="tanggal" name="date" required oninput="reloadItem(this.value)" value="{{$dateSet != null ? $dateSet : ''}}">
                        </div>
                    </div>
                    @foreach ($listRuang as $rooms)
                        @php
                        @$dayAvailable = explode(',', $rooms->day_available);
                        @endphp
                        @if(in_array($day, $dayAvailable))
                            <div class="mt-2">
                                <div class="card" style="border-radius: 4px;">
                                    <div class="row g-0">
                                        @php
                                            $fotoFoto = explode(',', $rooms->foto);
                                            $waktuTersedia = explode(',', $rooms->time_available)
                                        @endphp
                                        @if (strpos($rooms->foto, ',') !== false)
                                        <div class="col-md-4 p-3">
                                            <div id="roomCarousel{{$rooms->uuid}}" class="carousel slide" data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach ($fotoFoto as $fotoFoto2)
                                                    <div class="carousel-item {{$loop->iteration == 1 ?'active' : ''}}">
                                                        <img src="{{ asset('images/'.$fotoFoto2) }}" class="d-block w-100" alt="Room Image 1" style="border-radius: 4px;">
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel{{$rooms->uuid}}" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel{{$rooms->uuid}}" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </div>
                                        @else
                                        <div class="col-md-4 without-carousel p-3">
                                            <img src="{{ asset('images/'.$rooms->foto) }}" class="d-block w-100" alt="Room Image 1" style="border-radius: 4px;">
                                        </div>
                                        @endif
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $rooms->ruang }}</h5>
                                                <p class="card-text">{{ $rooms->lokasi }} (Kampus {{$rooms->kampus}})</p>
                                                <!-- Desktop -->
                                                <ul class="list-unstyled d-none d-sm-block">
                                                    <li>
                                                        <strong>Waktu Tersedia:</strong>
                                                        <div class="row">
                                                            @foreach ($waktuTersedia as $waktu)
                                                                @switch($waktu)
                                                                    @case(1)
                                                                    <div class="col-4">
                                                                        <ul>
                                                                            <li>Pagi - Siang</li>
                                                                        </ul>
                                                                    </div>
                                                                    @break
                                                                @case(2)
                                                                    <div class="col-4">
                                                                        <ul>
                                                                            <li>Siang - Sore</li>
                                                                        </ul>
                                                                    </div>
                                                                    @break
                                                                @case(3)
                                                                    <div class="col-4">
                                                                        <ul>
                                                                            <li>Pagi - Sore</li>
                                                                        </ul>
                                                                    </div>
                                                                    @break
                                                                @default
                                                                <div class="col-4">
                                                                    <ul>
                                                                        <li>-</li>
                                                                    </ul>
                                                                </div>
                                                                @endswitch
                                                            @endforeach
                                                        </div>
                                                    </li>
                                                </ul>
                                                <!-- Modile View -->
                                                <ul class="list-unstyled d-sm-none">
                                                    <li>
                                                        <strong>Waktu Tersedia:</strong>
                                                        <ul>
                                                            @foreach ($waktuTersedia as $waktu)
                                                                @switch($waktu)
                                                                    @case(1)
                                                                        <li>Pagi - Siang</li>
                                                                        @break
                                                                    @case(2)
                                                                        <li>Siang - Sore</li>
                                                                        @break
                                                                    @case(3)
                                                                        <li>Pagi - Sore</li>
                                                                        @break
                                                                    @default
                                                                        <li>-</li>
                                                                @endswitch
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                </ul>
                                                <a href="{{route('user.booking', ['uuid' => $rooms->uuid, 'date' => $dateSet])}}">
                                                    <button class="btn btn-outline-primary btn-sm">Booking</button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        flatpickr('#tanggal', {
            dateFormat: 'd-m-Y',
            minDate: 'today'
        });

        function reloadItem(date){
            console.log(date);
            const path = "{{route('user.index')}}";
            window.location.href = path+"?date="+date;

            // i want to redirect to path + ?date=date
        }
    </script>
    @endpush

</main>
@endsection
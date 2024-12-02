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
                                        <th scope="col">Kode Booking</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Ruangan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pending as $pend)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$pend->kode}}</td>
                                            <td>{{$pend->nama}}</td>
                                            <td>{{$pend->ruang->ruang}}</td>
                                            <td>{{ \Carbon\Carbon::parse($pend->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                                                    <a href="">
                                                        <button type="button" class="btn btn-sm btn-outline-info">Detail</button>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-success">Terima</button>
                                                    <button type="button" class="btn btn-sm btn-outline-danger">Tolak</button>
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
                                    @foreach($accept as $acc)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$acc->kode}}</td>
                                            <td>{{$acc->nama}}</td>
                                            <td>{{$acc->ruang->ruang}}</td>
                                            <td>{{ \Carbon\Carbon::parse($acc->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
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
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

@endsection
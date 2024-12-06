@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Riwayat Booking</li>
            </ol>
        </nav>
    </div>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title"></h5>
                        </div>
                        <!-- Tabel -->
                        <div style="overflow-x:auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Agenda Rapat</th>
                                        <th scope="col">Nama Ruangan</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Waktu</th>
                                        <th scope="col">Berkas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($riwayat as $list)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$list->nama}}</td>
                                            <td>{{$list->agenda_rapat}}</td>
                                            <td>{{$list->ruang->ruang}}</td>
                                            <td>{{ \Carbon\Carbon::parse($list->tanggal)->locale('id')->isoFormat('D MMMM YYYY') }}</td>
                                            <td>
                                                @switch($list->kode_waktu)
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
                                                @if($list->file)
                                                    <a href="{{url('/files/'.$list->file)}}" target="_blank">
                                                        <button type="button" class="btn btn-sm btn-outline-info"><i class="fa-regular fa-file"></i> Lihat</button>
                                                    </a>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-info"><i class="fa-solid fa-xmark"></i> Tidak ada</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada Data</td>
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
</main>

@endsection
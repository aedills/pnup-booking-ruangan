@extends('user/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('user.index')}}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Ruangan Tersedia</h5>

                    <div style="overflow-x:auto;">

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Ruang</th>
                                    <th scope="col">Gedung</th>
                                    <th scope="col">Waktu Tersedia</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($listRuang as $list)
                                @php
                                $time = explode(',', $list->time_available);
                                @endphp
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$list->ruang}}</td>
                                    <td>{{$list->gedung->gedung}}</td>
                                    <td>
                                        <ul>
                                            @foreach($time as $t)
                                                @switch($t)
                                                    @case('1')
                                                        <li>Pagi - Siang</li>
                                                        @break
                                                    @case('2')
                                                        <li>Siang - Sore</li>
                                                        @break
                                                    @case('3')
                                                        <li>Pagi - Sore</li>
                                                        @break
                                                @endswitch
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>Detail Booking</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada Data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>

@endsection
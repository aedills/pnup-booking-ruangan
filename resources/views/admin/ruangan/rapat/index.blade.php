@extends('admin/template/layout')

@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>{{$page_title}}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                <li class="breadcrumb-item">Data Ruangan</li>
                <li class="breadcrumb-item active"><a href="">R. Rapat</a></li>
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
                            <a href="{{route('admin.data-ruangan.rapat.create')}}">
                                <button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-plus"></i> Tambah</button>
                            </a>
                        </div>

                        <!-- Tabel -->
                        <div style="overflow-x:auto;">

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Ruang</th>
                                        <th scope="col">Lokasi</th>
                                        <th scope="col">Gedung</th>
                                        <th scope="col">Waktu Tersedia</th>
                                        <th scope="col">Hari Tersedia</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($dataruang as $list)
                                        @php
                                        $day = explode(',', $list->day_available);
                                        $time = explode(',', $list->time_available);
                                        @endphp
                                        <tr>
                                            <td scope="row">{{$loop->iteration}}</td>
                                            <td>{{$list->ruang}}</td>
                                            <td>{{$list->lokasi}}</td>
                                            <td>{{$list->gedung->gedung}} (Kampus {{$list->kampus}})</td>
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
                                            <td>
                                                <ul>
                                                    @foreach($day as $d)
                                                    <li>{{$d}}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                <a href="{{route('admin.data-ruangan.rapat.detail', ['uuid' => $list->uuid])}}"><button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-file-lines"></i> Detail</button></a>
                                                <a href="{{route('admin.data-ruangan.rapat.edit', ['uuid' => $list->uuid])}}"><button class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pencil"></i> Edit</button></a>
                                                <button class="btn btn-sm btn-outline-danger" onclick="confirmDelete('{{ route('admin.data-ruangan.rapat.delete', ['uuid' => $list->uuid]) }}')"><i class="fa-solid fa-trash"></i> Hapus</button>
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

    @push('scripts')
    <script>
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
                    // Perform the delete request
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
                                timer: 2500
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
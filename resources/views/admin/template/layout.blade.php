<!DOCTYPE html>
<html lang="en">

<head>
    @include('../../admin/template/components/header')
</head>

<body>
    <!-- Top Bar -->
    @include('../../admin/template/components/topbar')

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        @include('../../admin/template/components/sidebar')
    </aside>

    <!-- Main Content -->
    @yield('content')

    <div class="modal fade" id="passwordChangeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="passForm" class="row g-3 needs-validation" novalidate action="{{route('auth.changePass')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <label for="yourPassword" class="form-label">Password Lama</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="password" class="form-control" id="yourPassword" required>
                                <div class="invalid-feedback">Masukkan password lama!</div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="yourNewPassword" class="form-label">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text" id="inputGroupPrepend"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="newPassword" class="form-control" id="yourNewPassword" required>
                                <div class="invalid-feedback">Masukkan password baru!</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="passForm" class="btn btn-sm btn-outline-primary">Ganti Password</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="numberChange" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ganti Nomor Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="numberForm" class="row g-3 needs-validation" action="{{route('admin.changeNumber')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12">
                            <label class="form-label">Nomor Saat ini</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                                <input type="text" class="form-control" value="{{session('number')}}" disabled>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nomor Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-brands fa-whatsapp"></i></span>
                                <input type="text" class="form-control" name="newNumber" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="NumberPassConfirm" class="form-label">Password</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                                <input type="password" name="password" class="form-control" id="NumberPassConfirm" required>
                                <div class="invalid-feedback">Dengan alasan keamanan, masukkan password!</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" form="numberForm" class="btn btn-sm btn-outline-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('../../admin/template/components/footer')
</body>

</html>
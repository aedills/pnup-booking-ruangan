<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>{{env('APP_NAME')}}</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        Developed by <a target="_blank" href="https://google.com/">.RAR</a>
    </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

@livewireScripts
@stack('scripts')

<!-- Vendor JS Files -->
<script src="{{ url('res/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ url('res/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('res/assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ url('res/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ url('res/assets/vendor/quill/quill.js') }}"></script>
<script src="{{ url('res/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ url('res/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ url('res/assets/vendor/php-email-form/validate.js') }}"></script>

<!-- Template Main JS File -->
<script src="{{ url('res/assets/js/main.js') }}"></script>

<!-- J-Query -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session()->has('success'))
<script>
    Swal.fire({
        toast: true,
        position: "top-end",
        icon: "success",
        title: "{{ session()->get('success') }}",
        showConfirmButton: false,
        timer: 2500
    })
</script>
@endif

@if (session()->has('error'))
<script>
    Swal.fire({
        toast: true,
        position: "top-end",
        icon: "error",
        title: "{{ session()->get('error') }}",
        showConfirmButton: false,
        timer: 2500
    })
</script>
@endif
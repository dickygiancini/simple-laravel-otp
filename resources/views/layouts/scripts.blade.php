<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script src="https://kit.fontawesome.com/31cb9938fd.js" crossorigin="anonymous"></script>
<script src="{{ asset('js/axios.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.js') }}"></script>
<script src="{{ asset('js/jquery.js') }}"></script>
@yield('scripts')
<script type="text/javascript">
axios.interceptors.request.use(
    (config) => {
        Swal.fire({
            title: '<span class="loader"></span>',
            text: 'Sending Your Request to the Server...',
            allowOutsideClick: false,
            showCancelButton: false,
            showConfirmButton: false,
            onBeforeOpen: () => {
                Swal.showLoading();
            },
        }).then(() => {
            // Swal.close() will close the loading modal
            Swal.close();
        });
        return config;
    },(error) => {
        return Promise.reject(error);
    }
)
</script>

<!-- General JS Scripts -->
<script src="{{ asset('admintheme/assets/js/app.min.js') }}"></script>
<!-- JS Libraies -->
{{-- <script src="{{ asset('admintheme/assets/bundles/echart/echarts.js') }}"></script>

<script src="{{ asset('admintheme/assets/bundles/chartjs/chart.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/bundles/apexcharts/apexcharts.min.js') }}"></script>--}}
<!-- Page Specific JS File -->

<!-- Template JS File -->
{{-- <script src="{{ asset('admintheme/assets/bundles/prism/prism.js') }}"></script> --}}
<script src="{{ asset('admintheme/assets/js/scripts.js') }}"></script>
<script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/js/page/toastr.js') }}"></script>

<script>
    function showToaster(title,alertType, message) {
        console.log(alertType);
    var position = 'topRight'; // You can change the default position here

    var toastSettings = {
        title: title,
        message: message,
        position: position,
    };

    switch (alertType) {
        case 'info':
            iziToast.info(toastSettings);
            break;
        case 'success':
            iziToast.success(toastSettings);
            break;
        case 'warning':
            iziToast.warning(toastSettings);
            break;
        case 'error':
            iziToast.error(toastSettings);
            break;
    }
}
</script>

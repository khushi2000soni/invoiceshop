<script src="{{ asset('admintheme/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/js/page/toastr.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){


        @if(Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}";
            var message = "{{ Session::get('message') }}";

            switch (type) {
                case 'info':
                    iziToast.info({
                        title: 'Info!',
                        message: message,
                        position: 'topRight'
                    });
                    break;

                case 'warning':
                    iziToast.warning({
                        title: 'Warning!',
                        message: message,
                        position: 'topRight'
                    });
                    break;

                case 'success':
                    iziToast.success({
                        title: 'Success!',
                        message: message,
                        position: 'topRight'
                    });
                    break;

                case 'error':
                    iziToast.error({
                        title: 'Error',
                        message: message,
                        position: 'topRight'
                    });
                    break;
            }
        @endif


	});
</script>


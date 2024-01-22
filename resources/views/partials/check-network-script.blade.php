<script>
    var networkstatus = true;

    function checkConnectivity() {
        if (navigator.onLine) {
            $.ajax({
            url: '/check-connectivity',
            type: 'GET',
            success: function(response) {
                networkstatus = response.status;
               // console.log('network status',networkstatus);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                    // Handle connectivity issues
                    if (jqXHR.status === 500) {
                        // Server returned an error status
                        networkstatus = false;
                    } else {
                        // Other types of errors
                        networkstatus = false; // or handle differently based on your requirements
                    }
            }
            });
        } else {
            // Handle offline state
            console.log('offline');
            networkstatus = false;
        }
    }

    // Check connectivity every 5 seconds
    setInterval(checkConnectivity, 4000);


    function displaynetworkstatus(){
        if (networkstatus === false) {
            console.log(false);
            // Network is lost, show the div
            $(document).find('#OnlineComeBack').addClass('d-none');
            $(document).find('#internetlostMessage').removeClass('d-none');
        } else {
            console.log(true);
            // Network is available, hide the div OnlineComeBack
            $(document).find('#internetlostMessage').addClass('d-none');
            $(document).find('#OnlineComeBack').removeClass('d-none');
        }
    }

    setInterval(displaynetworkstatus, 4000);
</script>

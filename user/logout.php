<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Sweetalert JS v1.0.1 -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js'></script>


<?php
session_start();

session_unset();
session_destroy();
echo '
<script type="text/javascript">
$(document).ready(function() {
    swal({
        title: "Logged out Success",
        text: "Thank you!",
        type: "success",
        icon: "success",
        button:false,
    });
});
</script>
';
echo "Logged out... redirecting to main";
header("refresh:2;../index.php");

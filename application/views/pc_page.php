<!DOCTYPE html>
<html>
<head>
    <title>PC Page</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<h1>Waiting for QR scan...</h1>

<script>
function checkTrigger() {
    $.get("<?php echo site_url('qr_code/check_trigger'); ?>", function(data) {
        if(data == "1") {
            // Redirect PC to another page when triggered
            window.location.href = "<?php echo site_url('welcome/another_page'); ?>";
        }
    });
}

// Poll every 2 seconds
setInterval(checkTrigger, 2000);/
</script>

</body>
</html>

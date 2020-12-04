<?php
// include header file
include 'header.php';
// Get config data
$configData = configItem();
?>
<!DOCTYPE html>
<!-- Html Start -->
<html>
<!-- Head Start -->
<head>
    <!-- Page Title -->
    <title>Pay Page</title>
    <!-- /Page Title -->
    <!-- Load load bootstrap and fontawesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- /Load load bootstrap and fontawesome -->
</head>
<!-- /Head End -->
<!-- Body Start -->
<body>
    <div class="text-center mt-5">
        <div class="col-lg-12 text-center">
            <!-- Thanks message -->
            <h3>Thanks for your payment</h3>            
            <!-- Success Icon -->
            <i class="fa fa-check-square-o fa-5x text-success"></i>
            <!-- /Success Icon -->
            <h1>Payment succeed</h1>
            <!-- /Thanks message -->
            <!-- URL for back to checkout form -->
            <a href="<?= getAppUrl() ?>" title="Back to Checkout Form">Back to Checkout Form</a>
            <!-- /URL for back to checkout form -->
        </div>
    </div>
</body>
<!-- /Body Start -->
</html>
<!-- /Html End -->
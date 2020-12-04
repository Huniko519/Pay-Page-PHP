<?php 
// Include header file
include 'header.php';
?>
<!-- Page HTML Start here -->
<!DOCTYPE html>
<html>
<!-- Index page head start here -->
<head>
    <!-- Page Title -->
    <title>Pay Page</title>
    <!-- Page Title -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load JQuery, bootstrap, font-awesome, and custom css -->
    <script src="./assets/js/jquery-3.3.1.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css/custom.css" type="text/css">
    <!-- /Load JQuery, bootstrap, font-awesome, and custom css -->
</head>
<!-- /Index page head end here -->
<!-- Page body start from here... -->
<body>
    <!-- Show loader when process payment request -->
    <div class="d-flex justify-content-center">
        <div class="lw-page-loader lw-show-till-loading">
            <div class="spinner-border"  role="status"></div>
        </div>
    </div>
    <!-- Show loader when process payment request -->

    <!-- Payment form start from here -->
    <div class="pt-4 mb-5 container" id="lwCheckoutForm">
        <div class="row">
            <div class="col-md-4 lw-logo-section">
                <!-- Payment page logo -->
                <div class="lw-logo-container">
                    <img class="lw-logo" src="assets/imgs/logo-for-site.png">
                </div>
                <!-- /Payment page logo -->
                <!-- Payment Page Other Information -->
                <h5>PHP ready to use Payment Gateway Integrations</h5>
                <hr class="mb-4">
                <h6>Ready to use </h6>
                <h6>Easy Integration</h6>
                <h6>Many Gateways</h6>
                <h6>Well Documented</h6>
                <!-- Payment Page Other Information -->
                <hr class="mb-4">
                <div class="form-group">
                    <label for="individualPaymentGateway">Individual payment gateway integration</label>
                    <select class="form-control" id="individualPaymentGateway">
                        <option value="" selected>All</option>
                        <option value="paypal">PayPal</option>
                        <option value="paytm">PayTM</option>
                        <option value="instamojo">Instamojo</option>
                        <option value="paystack">Paystack</option>
                        <option value="stripe">Stripe</option>
                        <option value="razorpay">Razorpay</option>
                        <option value="iyzico">Iyzico</option>
                        <option value="authorize-net">Authorize.Net</option>
                        <option value="bitpay">BitPay</option>
                    </select>
                </div>

            </div>
            <!-- col-md-8 -->
            <div class="col-md-8">
                <!-- payment gateway start -->
                <form method="post" id="lwPaymentForm">
                    <!-- Card Start here -->
                    <div class="card">
                        <!-- Payment Page header -->
                        <div class="card-header">
                            <h3 class="text-center">Complete your payment</h3>
                        </div>
                        <!-- /Payment Page header -->

                        <!-- Card body start here -->
                        <div class="card-body">
                            <!-- Info Message -->
                            <div class="alert alert-info">
                                This is just an example, you can integrate these payment gateway easily using this example implementation.
                            </div>
                            <!-- Info Message -->

                            <!-- show validation message block -->
                            <div id="lwValidationMessage" class="lw-validation-message"></div>
                            <!-- / show validation message block -->
                            <?php 
                                // Get config data
                                $configData = configItem();
                                $userDetails = [
                                    'amounts' => [ // at least one currency amount is required
                                        'USD'   => 10,
                                        'INR'   => 709,
                                        'NGN'   => 3615,
                                        'TRY'   => 57
                                    ],
                                    'order_id'      => 'ORDS' . uniqid(), // required in instamojo, Iyzico, Paypal, Paytm gateways
                                    'customer_id'   => 'CUSTOMER' . uniqid(), // required in Iyzico, Paytm gateways
                                    'item_name'     => 'Sample Product', // required in Paypal gateways
                                    'item_qty'      => 1,
                                    'item_id'       => 'ITEM' . uniqid(), // required in Iyzico, Paytm gateways
                                    'payer_email'   => 'sample@domain.com', // required in instamojo, Iyzico, Stripe gateways
                                    'payer_name'    => 'John Doe', // required in instamojo, Iyzico gateways
                                    'description'   => 'Lorem ipsum dolor sit amet, constetur adipisicing', // Required for stripe
                                    'ip_address'    => getUserIpAddr(), // required only for iyzico 
                                    'address'       => '3234 Godfrey Street Tigard, OR 97223', // required in Iyzico gateways
                                    'city'          => 'Tigard',  // required in Iyzico gateways
                                    'country'       => 'United States' // required in Iyzico gateways
                                ];

                                if (!$configData) {
                                    // If config data not found then show error
                                    echo '<div class="alert alert-warning text-center">Unable to load configuration.</div>';
                                } else {
                                    // Get Gateway configuration
                                    $configItem = $configData['payments']['gateway_configuration'];
                                ?>

                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <h3>Customer Details</h3>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Name:</strong> <?= $userDetails['payer_name'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Email:</strong> <?= $userDetails['payer_email'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Address:</strong> <?= $userDetails['address'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>City:</strong> <?= $userDetails['city'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Country:</strong> <?= $userDetails['country'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Additional info:</strong> <?= $userDetails['description'] ?>
                                    </li>
                                    <li class="list-group-item">
                                        <strong>Item Name:</strong> <?= $userDetails['item_name'] ?>
                                    </li>
                                </ul>

                                <h5 class="mt-4">Choose your payment method</h5>
                                <hr>
                                <?php
                                    // Show all enable payment Gateway
                                    foreach ($configItem as $key => $value) { 
                                        // Check if payment gateway is enable from config
                                        if ($value['enable']) { ?>
                                            <!-- Payment gateway radio buttons with image -->
                                            <div class="form-check form-check-inline">
                                                <!-- radio button label -->
                                                <label class="form-check-label" for="paymentOption-<?= $key ?>">
                                                    <!-- Filedset for big image -->
                                                    <fieldset class="lw-fieldset mr-3 mb-3">
                                                        <!-- small image legend -->
                                                        <legend class="lw-fieldset-legend-font">
                                                            <input class="form-check-input" type="radio" required="true" id="paymentOption-<?= $key ?>" name="paymentOption" value="<?= $key ?>">
                                                            <!-- payment gateway small image --> 
                                                            <img class="lw-payment-gateway-icon-small" src="assets/imgs/payment-images/<?= $key ?>-small.png">
                                                            <!-- /payment gateway small image --> 
                                                        </legend>
                                                        <!-- /small image legend -->
                                                        <!-- payment gateway big image --> 
                                                        <img class="lw-payment-gateway-icon" src="assets/imgs/payment-images/<?= $key ?>-big.jpg">
                                                        <!-- /payment gateway big image --> 
                                                    </fieldset>
                                                    <!-- /Filedset for big image -->
                                                </label>
                                                <!-- /radio button label -->
                                            </div> <?php 
                                            // Payment gateway radio buttons with image
                                        }
                                    } ?>
                                <br><br>
                                <!-- Iyzico Merchant Form Start here -->
                                <div class="lw-iyzico-form card mb-3" id="cardCheckoutForm">
                                    <!-- Iyzico payment method header -->
                                    <div class="card-header">
                                        <h5 class="card-title display-td" >Your Card Details</h5>
                                        <small class="text-danger">All fields are required.</small>
                                    </div>
                                    <!-- /Iyzico payment method header -->

                                    <!-- Card Body start here -->
                                    <div class="card-body mb-3">                                        
                                        <!-- name of card -->
                                        <div class="form-group">
                                            <label for="cname">Name on Card</label>
                                            <input type="text" class="form-control" id="cname" name="cardname" placeholder="John More Doe">
                                        </div>
                                        <!-- / name of card -->

                                        <!-- Card number -->
                                        <div class="form-group">
                                            <label for="cardNumber">Card Number</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control" id="cardNumber" name="cardnumber">
                                                <div class="input-group-append" id="basic-addon1">
                                                    <span class="input-group-text"><i class="fa fa-credit-card"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- / Card number -->                                        

                                        <div class="form-row">
                                            <div class="col">
                                                <!-- Set card expiry month -->
                                                <label for="expmonth">Exp Month</label>
                                                <input type="number" class="form-control" id="expmonth" name="expmonth">
                                                <!-- / Set card expiry month -->
                                            </div>
                                            <div class="col">
                                                <!-- Set card expiry year -->
                                                <label for="expyear">Exp Year</label>
                                                <input type="number" class="form-control" id="expyear" name="expyear">
                                                <!-- / Set card expiry year -->
                                            </div>
                                            <div class="col">
                                                <!-- Set card cvv number -->
                                                <label for="cvv">CVV</label>
                                                <input type="number" class="form-control" id="cvv" name="cvv">
                                                <!-- Set card cvv number -->
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Card Body start here -->
                                </div>
                                <!-- / Iyzico Merchant Form  -->
                                <h3 id="lwPaymentAmount"></h3>
                                <!--  checkout form submit button -->
                                <button type="submit" value="Proceed to Pay" class="btn btn-lg btn-block btn-success">Proceed to Pay</button>
                                <!-- / checkout form submit button -->
                            </div><?php } ?>
                            <!-- Card body end here -->
                        </div>
                        <!-- /Card end here -->
                    </div>
                    <!-- /col-md-8 -->
                </form>
                <!-- /payment gateway end -->
            </div>
        </div>
    </div>
    <!-- /Payment form end from here -->
    <footer class="footer bg-light p-4 text-center">
        PayPage - 1.2.0 - <small class="text-muted"> PHP ready to use Payment Gateway Integrations</small> Design & Developed by <a href="https://livelyworks.net">LivelyWorks</a>
    </footer>
</body>
<!-- /Page body end from here... -->
</html>
<!-- /Page HTML end here -->
<!-- get configuration data -->
<?php 
    // Get config data
    $config             = getPublicConfigItem();
    // Get app URL
    $paymentPagePath    = getAppUrl();

    $gatewayConfiguration = $config['payments']['gateway_configuration'];
    // get paystack config data
    $paystackConfigData = $gatewayConfiguration['paystack'];
    // Get paystack callback ur
    $paystackCallbackUrl= getAppUrl($paystackConfigData['callbackUrl']);

    // Get stripe config data
    $stripeConfigData   = $gatewayConfiguration['stripe'];
    // Get stripe callback ur
    $stripeCallbackUrl  = getAppUrl($stripeConfigData['callbackUrl']);

    // Get razorpay config data
    $razorpayConfigData = $gatewayConfiguration['razorpay'];
    // Get razorpay callback url
    $razorpayCallbackUrl= getAppUrl($razorpayConfigData['callbackUrl']);

    // Get Authorize.Net config Data
    $authorizeNetConfigData = $gatewayConfiguration['authorize-net'];
    // Get Authorize.Net callback url
    $authorizeNetCallbackUrl= getAppUrl($authorizeNetConfigData['callbackUrl']);

    // Individual payment gateway url
    $individualPaymentGatewayAppUrl = getAppUrl('individual-payment-gateways');
?>
<!-- / get configuration data -->

<!-- apply validation for iyzico form data -->
<script type="text/javascript">
    // On load hide iyzico form
    $("#cardCheckoutForm").hide();
    // Check if payment options are get changed and if iyzico payment gateway is selected then 
    // add validation error to form element
    var gatewayConfiguration = <?= json_encode($gatewayConfiguration) ?>,
    userDetails = <?= json_encode($userDetails) ?>;
    $('input[name=paymentOption]').change(function(){
        // Get value of payment option
        var selectedPayment = $( 'input[name=paymentOption]:checked' ).val();
        // Check if iyzico payment method is selected
        var gatewayCurrency = gatewayConfiguration[selectedPayment]['currency'],
            currencySymbol = gatewayConfiguration[selectedPayment]['currencySymbol'],
            formattedAmount = '<hr>' + currencySymbol + ' ' + userDetails['amounts'][gatewayCurrency] + ' ' + gatewayCurrency + '<hr>';
            
        $('#lwPaymentAmount').html(formattedAmount);
        // then show iyzico form 
        if (selectedPayment == 'iyzico' || selectedPayment == 'authorize-net') {
            // Show form element
            $("#cardCheckoutForm").show();
            // add required validation to cname input
            $("#cname").attr("required","true");
            // add required validation to cardNumber input
            $("#cardNumber").attr("required","true");
            // add required validation to expmonth input
            $("#expmonth").attr("required","true");
            // add required validation to expyear input
            $("#expyear").attr("required","true");
            // add required validation to cvv input
            $("#cvv").attr("required","true");
        } else {
            // Hide iyzico form
            $("#cardCheckoutForm").hide();
            // Remove validation from cname input
            $("#cname").removeAttr("required","true");
            // Remove validation from cardNumber input
            $("#cardNumber").removeAttr("required","true");
            // Remove validation from expmonth input
            $("#expmonth").removeAttr("required","true");
            // Remove validation from expyear input
            $("#expyear").removeAttr("required","true");
            // Remove validation from cvv input
            $("#cvv").removeAttr("required","true");
        }
    });
</script>
<!-- / apply validation for iyzico form data -->

<!-- Jquery Form submit in script tag -->
<script type="text/javascript">
   
    $(document).ready(function(){
        // redirect on individual payment page
        $('select#individualPaymentGateway').on('change', function() {
            var paymentMethod = this.value;
            if (paymentMethod != '') {
                window.location.href = "<?= $individualPaymentGatewayAppUrl ?>/" + this.value + '-payment.php';
            } else {
                window.location.href = "<?= $paymentPagePath ?>";
            }
        });

        //submit checkout form
        $('#lwPaymentForm').on('submit', function(e){ 
            // Prevent form 
            e.preventDefault();
            // Get value of selected payment method
            var paymentOption = $( 'input[name=paymentOption]:checked' ).val();
           
            // Paypal, Paytm, Instamojo or iyzico script for send ajax request to server side start
            if (paymentOption == 'paypal' || paymentOption == 'paytm' || paymentOption == 'instamojo' || paymentOption == 'iyzico' || paymentOption == 'authorize-net' || paymentOption == 'bitpay') {
                
                //show loader before ajax request
                $(".lw-show-till-loading").show();

                //send ajax request with form data to server side processing
                $.ajax({
                    type: 'post', //form method
                    context: this,
                    url: 'payment-process.php', // post data url
                    dataType: "JSON",
                    data: $('#lwPaymentForm').serialize() + '&' + $.param(JSON.parse('<?php echo json_encode($userDetails) ?>')), // form serialize data
                    error: function (err) {
                        var error = err.responseText
                            string = '';
                        
                        //on error show alert message
                        string += '<div class="alert alert-danger" role="alert">'+err.responseText+'</div>';

                        $('#lwValidationMessage').html(string);
                        //alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));

                        //hide loader after ajax request complete
                        $(".lw-show-till-loading").hide();
                    },
                    success: function (response) {
                     
                       //check server side validation
                        if (typeof(response.validationMessage)) {

                            var messageData = [],
                                string = '';

                            //validation message
                            $.each(response.validationMessage, function(index, value) {
                                messageData = value;
                                string += '<div class="alert alert-danger" role="alert">'+messageData+'</div>';
                            });

                            //print error mesaages
                            $('#lwValidationMessage').html(string);

                            //hide loader after ajax request complete
                            $(".lw-show-till-loading").hide();
                        }
                       
                        //load paytm merchant form
                        if (response.paymentOption == "paytm") {    

                            $('body').html(response.merchantForm);

                        } else if(response.paymentOption == "instamojo") {

                            //on success load instamojo long url page else show error message
                            if (response.message == 'success') {
                                //show loader before page load
                                $(".lw-show-till-loading").show();

                                window.location.href = response.longurl;
                            } else {
                                //error message
                                string += '<div class="alert alert-danger" role="alert">'+response.errorMessage+'</div>';

                                //print error mesaages
                                $('#lwValidationMessage').html(string);
                            }
                            
                        } else if(response.paymentOption == "iyzico") {
                           
                            //on success load html content page on iyzico else show error message
                            if (response.status == 'success') {
                                $('body').html(response.htmlContent);

                            } else if (response.message == 'failed') {

                                string += '<div class="alert alert-danger" role="alert">'+response.errorMessage+'</div>';
                            }

                            else {
                                //error message
                                //validation message
                                $.each(response.validationMessage, function(index, value) {
                                    messageData = value;
                                    string += '<div class="alert alert-danger" role="alert">'+messageData+'</div>';
                                });
                            }
                            //print error mesaages
                            $('#lwValidationMessage').html(string);

                        } else if(response.paymentOption == "paypal") {
                            
                            //show loader before page load
                            $(".lw-show-till-loading").show();

                           //on success load paypalUrl page
                            window.location.href = response.paypalUrl;
                        } else if (response.paymentOption == 'authorize-net') {
                            var authorizeNetCallbackUrl = <?php echo json_encode($authorizeNetCallbackUrl); ?>;
                            if (response.status == "success") {
                                $('body').html("<form action='"+authorizeNetCallbackUrl+"' method='post'><input type='hidden' name='response' value='"+JSON.stringify(response)+"'><input type='hidden' name='paymentOption' value='authorize-net'></form>");
                                $('body form').submit();
                            } else if (response.status == "error") {
                                string = response.message;                        
                            } else {
                                $.each(response.validationMessage, function(index, value) {
                                    messageData = value;
                                    string += '<div class="alert alert-danger" role="alert">'+messageData+'</div>';
                                });
                            }
                            $('#lwValidationMessage').html(string);
                        } else if (response.paymentOption == 'bitpay') {
                            if (response.status == "success") {
                                window.location.href = response.invoiceUrl;
                            } else {
                                $('#lwValidationMessage').html('Something went wrong on server.');
                                $(".lw-show-till-loading").hide();
                            }
                        }
                    }
                });
            // Paypal, Paytm, Instamojo or iyzico script for send ajax request to server side end

            // Paystack script for send ajax request to server side start
            } else if (paymentOption == 'paystack') {

                //config data
                var configData = <?php echo json_encode($config); ?>,
                    paymentPagePath = <?php echo json_encode($paymentPagePath); ?>,
                    configItem = configData['payments']['gateway_configuration']['paystack'],
                    paystackCallbackUrl = configItem.callbackUrl,
                    userDetails = <?php echo json_encode($userDetails); ?>;
                    
                    const amount =  userDetails['amounts'][configItem['currency']];

                var paystackPublicKey = '';
                
                //check paystack test or production mode
                if (configItem['testMode']) {
                    paystackPublicKey = configItem['paystackTestingPublicKey'];
                } else {
                    paystackPublicKey = configItem['paystackLivePublicKey'];
                }

                var paystackAmount = amount.toFixed(2) * 100,
                    handler = PaystackPop.setup({
                    key: paystackPublicKey, // add paystack public key
                    email: userDetails['payer_email'], // add customer email
                    amount: paystackAmount, // add order amount
                    currency: configItem['currency'], // add currency
                    callback: function(response){
                        // after successful paid amount return paystack reference Id
                        var paystackReferenceId = response.reference;

                        //show loader before ajax request
                        $(".lw-show-till-loading").show();

                        var paystackData = {
                            'paystackReferenceId': paystackReferenceId,
                            'paystackAmount': paystackAmount
                        };

                        var paystackData = $('#lwPaymentForm').serialize() + '&' + $.param(userDetails) + '&' + $.param(paystackData);

                        $.ajax({
                            type: 'post', //form method
                            context: this,
                            url: 'payment-process.php', // post data url
                            dataType: "JSON",
                            data: paystackData, // form serialize data
                            error: function (err) {
                                var error = err.responseText
                                    string = '';
                                
                                //on error show alert message
                                string += '<div class="alert alert-danger" role="alert">'+err.responseText+'</div>';

                                $('#lwValidationMessage').html(string);
                                //alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));

                                //hide loader after ajax request complete
                                $(".lw-show-till-loading").hide();
                            },
                            success: function (response) {
                                if (response.status == true) {
                                    $('body').html("<form action='"+paystackCallbackUrl+"' method='post'><input type='hidden' name='response' value='"+JSON.stringify(response)+"'><input type='hidden' name='paymentOption' value='paystack'></form>");
                                    $('body form').submit();
                                }
                            }
                        });

                    },
                    onClose: function(){
                        //on close paystack inline widget then load back to checkout form page
                       // window.location.href = paymentPagePath;
                    }
                });

                //open paystack inline widen using iframe
                handler.openIframe();
            // Paystack script for send ajax request to server side end


            // Stripe script for send ajax request to server side start
            } else if (paymentOption == 'stripe') {

                //config data
                var configData = <?php echo json_encode($config); ?>,
                    configItem = configData['payments']['gateway_configuration']['stripe'],
                    userDetails = <?php echo json_encode($userDetails); ?>,
                    stripePublishKey  = '';
                $(".lw-show-till-loading").show();
                
                //check stripe test or production mode
                if (configItem['testMode']) {
                    stripePublishKey = configItem['stripeTestingPublishKey'];
                } else {
                    stripePublishKey = configItem['stripeLivePublishKey'];
                }

                userDetails['paymentOption'] = paymentOption;

                // Stripe script for send ajax request to server side start
                $.ajax({
                    type: 'post', //form method
                    context: this,
                    url: 'payment-process.php', // post data url
                    dataType: "JSON",
                    data: userDetails, // form serialize data
                    error: function (err) {
                        var error = err.responseText
                            string = '';
                        console.log(err);
                        //on error show alert message
                        string += '<div class="alert alert-danger" role="alert">'+err.responseText+'</div>';

                        $('#lwValidationMessage').html(string);
                        //alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));

                        //hide loader after ajax request complete
                        $(".lw-show-till-loading").hide();
                    },
                    success: function (response) {

                        var stripe = Stripe(stripePublishKey);
                        stripe.redirectToCheckout({
                            // Make the id field from the Checkout Session creation API response
                            // available to this file, so you can provide it as parameter here
                            // instead of the {{CHECKOUT_SESSION_ID}} placeholder.
                            sessionId: response.id,
                        }).then(function (result) {
                            // If `redirectToCheckout` fails due to a browser or network
                            // error, display the localized error message to your customer
                            // using `result.error.message`.
                            var string = '';                                
                            //on error show alert message
                            string += '<div class="alert alert-danger" role="alert">'+result.error.message+'</div>';

                            $('#lwValidationMessage').html(string);
                        });
                        
                    }
                });

            // Razorpay script for send ajax request to server side start
            } else if (paymentOption == 'razorpay') {

                //config data
                var configData = <?php echo json_encode($config); ?>,
                    razorpayCallbackUrl = <?php echo json_encode($razorpayCallbackUrl); ?>,
                    paymentPagePath = <?php echo json_encode($paymentPagePath); ?>,
                    configItem = configData['payments']['gateway_configuration']['razorpay'],
                    userDetails = <?php echo json_encode($userDetails); ?>,
                    razorpayKeyId = '';
                    
                const amount =  userDetails['amounts'][configItem['currency']];

                //check razorpay test or production mode
                if (configItem['testMode']) {
                    razorpayKeyId = configItem['razorpayTestingkeyId'];
                } else {
                    razorpayKeyId = configItem['razorpayLivekeyId'];
                }

                var razorpayAmount = amount.toFixed(2) * 100,
                    razorpayPaymentId = null,
                    options = {
                    "key": razorpayKeyId, // add razorpay Api Key Id
                    "amount": razorpayAmount, // 2000 paisa = INR 20
                    "currency": configItem['currency'], // add currency
                    "name": configItem['merchantname'], // add merchant user name
                    "handler": function (response){
                        // after successful paid amount return razorpay payment Id
                        razorpayPaymentId = response.razorpay_payment_id;
                        var encodeRazorpayAmount =  window.btoa(razorpayAmount);
                        //show loader before ajax request
                        $(".lw-show-till-loading").show();
                        
                        var razorpayData = {
                            'razorpayPaymentId': razorpayPaymentId,
                            'razorpayAmount': encodeRazorpayAmount
                        };

                        var razorpayData = $('#lwPaymentForm').serialize() + '&' + $.param(userDetails) + '&' + $.param(razorpayData);

                        $.ajax({
                            type: 'post', //form method
                            context: this,
                            url: 'payment-process.php', // post data url
                            dataType: "JSON",
                            data: razorpayData, // form serialize data
                            error: function (err) {
                                var error = err.responseText
                                    string = '';
                                
                                //on error show alert message
                                string += '<div class="alert alert-danger" role="alert">'+err.responseText+'</div>';

                                $('#lwValidationMessage').html(string);
                                //alert("AJAX error in request: " + JSON.stringify(err.responseText, null, 2));

                                //hide loader after ajax request complete
                                $(".lw-show-till-loading").hide();
                            },
                            success: function (response) {
                                if (response.status == "captured") {
                                    razorpayCallbackUrl = razorpayCallbackUrl+'?orderId='+userDetails['order_id'];
                                    $('body').html("<form action='"+razorpayCallbackUrl+"' method='post'><input type='hidden' name='response' value='"+JSON.stringify(response)+"'><input type='hidden' name='paymentOption' value='razorpay'></form>");
                                    $('body form').submit();
                                }
                            }
                        });

                        //after successful payment go to response page
                        /* window.location.href = razorpayCallbackUrl+'?paymentOption='+paymentOption+'&razorpayPaymentId='+razorpayPaymentId+'&amount='+encodeRazorpayAmount; */
                    },
                    "prefill": {
                        "name": userDetails['payer_name'], // add user name
                        "email": userDetails['payer_email'], // add user email
                    },
                    "theme": {
                        "color": configItem['themeColor'], // add widget theme color
                    },
                    "modal": {
                        "ondismiss": function(e){
                            // if razorpay payment Id is not received on onDismiss razorpay inline widget then load Url back to checkout form page
                            if (razorpayPaymentId == null) {
                                //window.location.href = paymentPagePath;
                            }
                        }
                    }
                };
                var rzp1 = new Razorpay(options);
                rzp1.open();
            }
        });
    });
</script>
<!-- /  Jquery Form submit in script tag -->

<?php
if ($paystackConfigData['enable']) { ?>
    <!-- load paystack inline widget script -->
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <!-- / load Paystack inline widget script -->
<?php } ?>

<?php 
if ($stripeConfigData['enable']) { ?>
    <!-- load stripe inline widget script -->
    <script src="https://js.stripe.com/v3"></script>
    <!-- load stripe inline widget script -->
<?php } ?>

<?php 
if ($razorpayConfigData['enable']) { ?>
    <!-- load razorpay inline widget script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <!-- load razorpay inline widget script -->
<?php } ?>
<script src="//code.jivosite.com/widget.js" data-jv-id="w3uEOsnaEE" async></script>
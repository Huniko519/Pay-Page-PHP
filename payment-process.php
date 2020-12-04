<?php  
// Include Header file
include 'header.php';

/*
 * Use PaymentProcess Class
 * Use PaytmService Class
 * Use InstamojoService Class
 * Use IyzicoService Class
 * Use PaypalService Class
 * Use PaystackService Class
 * Use RazorpayService Class
 * Use StripeService Class
 * Use AuthorizeNetService Class
 */
use App\Components\Payment\PaymentProcess;
use App\Service\PaytmService;
use App\Service\InstamojoService;
use App\Service\IyzicoService;
use App\Service\PaypalService;
use App\Service\PaystackService;
use App\Service\RazorpayService;
use App\Service\StripeService;
use App\Service\AuthorizeNetService;
use App\Service\BitPayService;

/*
 * Get instance of paytm service
 */
$paytmService       = new PaytmService();

/*
 * Get instance of instamojo service
 */
$instamojoService   = new InstamojoService();

/*
 * Get instance of iyzico service
 */
$iyzicoService      = new IyzicoService();

/*
 * Get instance of paypal service
 */
$paypalService      = new PaypalService();

/*
 * Get instance of paystack service
 */
$paystackService      = new PaystackService();

/*
 * Get instance of razorpay service
 */
$razorpayService      = new RazorpayService();

/*
 * Get instance of stripe service
 */
$stripeService      = new StripeService();

/*
 * Get instance of authorize service
 */
$authorizeNetService = new AuthorizeNetService();

/*
 * Get instance of BitPay service
 */
$bitPayService = new BitPayService();

/*
 * Process a payment with anyone service
 */
$paymentProcess     = new PaymentProcess(
                                $paytmService, 
                                $instamojoService, 
                                $iyzicoService, 
                                $paypalService, 
                                $paystackService, 
                                $razorpayService, 
                                $stripeService,
                                $authorizeNetService,
                                $bitPayService
                        );  
/*
 * Get instance of GUMP, its a validation library for PHP
 */
$gump = new GUMP();

//check post data is not empty
if (isset($_POST) && count($_POST) > 0 ) {
    // Sanitize form input data, remove tags for security purpose
    $insertData = $gump->sanitize($_POST);

    // Apply validation rule for post request.
    $validation = GUMP::is_valid($insertData, array(
        //'amount'        => 'required|numeric|min_numeric,0',
        'paymentOption' => 'required'
    ));
  
    $paymentOption = $insertData['paymentOption'];
    
    // Check if iyzico or authorize-net payment method is used then check iyzico or authorize-net form data like
    // amount, option, cardname, card number, expiry month, expiry year, cvv etc and validate it
    if ($paymentOption == 'iyzico' or $paymentOption == 'authorize-net') {
        $validation = GUMP::is_valid($insertData, array(
            //'amount'        => 'required|numeric',
            'paymentOption' => 'required',
            'cardname'     => 'required',
            'cardnumber'   => 'required',
            'expmonth'     => 'required',
            'expyear'      => 'required',
            'cvv'          => 'required'
        ));
    }

    // Check server side validation success then process for next step
    if ($validation === true) {

        // Then send data to payment process service for process payment
        // This service will return payment data
        $paymentData = $paymentProcess->getPaymentData($insertData);

        // set select payment option in return paymentData array
        $paymentData['paymentOption'] = $paymentOption;

        //on success paytm response
        if ($paymentOption == 'paytm') {
           
            // If paytm payment method are selected then get payment merchant form
            $paymentData['merchantForm'] = getPaytmMerchantForm($paymentData);
           
            // return payment array on ajax request
            echo json_encode($paymentData);

            // on success instamojo, paystack, stripe, razorpay, iyzico & paypal response
        //} else if () {
            
        } else if ($paymentOption == 'instamojo' || $paymentOption == 'paystack' || $paymentOption == 'iyzico' || $paymentOption == 'paypal' || $paymentOption == 'stripe' || $paymentOption == 'authorize-net' || $paymentOption == 'bitpay') {

            // return payment array on ajax request
            echo json_encode($paymentData);    

        } else if ($paymentOption == 'razorpay') {
            echo json_encode(array_values($paymentData)[0]);
        }

    } else {
        // If Validation errors occurred then show it on the form
        $validationMessage = [];
        
        // get collection of validation messages
        foreach ($validation as $valid) {
            $validationMessage['validationMessage'][] = strip_tags($valid);
        }
      
        // return validation array on ajax request
        echo json_encode($validationMessage);
        
        exit();
    }
}
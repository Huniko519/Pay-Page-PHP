<?php
// Include Header file
include 'header.php';

/*
 * Use PaytmResponse Class
 * Use PaystackResponse Class
 * Use StripeResponse Class
 * Use RazorpayResponse Class
 * Use InstamojoResponse Class
 * Use IyzicoResponse Class
 * Use PaypalIpnResponse Class
  * Use BitPayResponse Class
 */
use App\Components\Payment\PaytmResponse;
use App\Components\Payment\PaystackResponse;
use App\Components\Payment\StripeResponse;
use App\Components\Payment\RazorpayResponse;
use App\Components\Payment\InstamojoResponse;
use App\Components\Payment\IyzicoResponse;
use App\Components\Payment\PaypalIpnResponse;
use App\Components\Payment\BitPayResponse;

// Get Config Data 
$configData = configItem();
// Get Request Data when payment success or failed
$requestData = $_REQUEST;

// Check payment Method is paytm
if ($requestData['paymentOption'] == 'paytm') {
    // Get Payment Response instance
    $paytmResponse  = new PaytmResponse();

    // Fetch payment data using payment response instance
    $paytmData = $paytmResponse->getPaytmPaymentData($requestData);
    
    // Check if payment status is success
    if ($paytmData['STATUS'] == 'TXN_SUCCESS') {

        // Create payment success response data.
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response.
        paymentResponse($paymentResponseData);
    } else {
        // Create payment failed response data.
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $paytmData,
            'data'     => preparePaymentData($paytmData['ORDERID'], $paytmData['TXNAMOUNT'], $paytmData['TXNID'], 'paytm')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }   
// Check payment method is instamojo
} else if ($requestData['paymentOption'] == 'instamojo') {
    
    // Check if payment successfully procced
    if ($requestData['payment_status'] == "Credit") {

        // Get Instance of instamojo response service
        $instamojoResponse  = new InstamojoResponse();

        // fetch payment data from instamojo response instance
        $instamojoData = $instamojoResponse->getInstamojoPaymentData($requestData);
        
        // Prepare data for payment response
        $paymentResponseData = [
            'status'   => true,
            'rawData'  => $instamojoData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], $instamojoData['payment_id'], 'instamojo')
        ];
        // Send data to payment response
        paymentResponse($paymentResponseData);
    // Check if payment failed then send failed response
    } else {
        // Prepare data for failed response data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $instamojoData['amount'], null, 'instamojo')
        ];
        // Send data to payment response function
        paymentResponse($paymentResponseData);
    }

// Check if payment method is iyzico.
} else if ($requestData['paymentOption'] == 'iyzico') {
    
    // Check if payment status is success for iyzico.
    if ($_REQUEST['status'] == 'success') {
        // Get iyzico response.
        $iyzicoResponse  = new IyzicoResponse();

        // fetch payment data using iyzico response instance.
        $iyzicoData = $iyzicoResponse->getIyzicoPaymentData($requestData);
        $rawResult = json_decode($iyzicoData->getRawResult(), true);
        
        // Check if iyzico payment data is success
        // Then create a array for success data
        if ($iyzicoData->getStatus() == 'success') {
            $paymentResponseData = [
                'status'   => true,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];
            // Send data to payment response
            paymentResponse($paymentResponseData);
        // If payment failed then create data for failed
        } else {
            // Prepare failed payment data
            $paymentResponseData = [
                'status'   => false,
                'rawData'  => (array) $iyzicoData,
                'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], $rawResult['conversationId'], 'iyzico')
            ];
            // Send data to payment response
            paymentResponse($paymentResponseData);
        }
    // Check before 3d payment process payment failed
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => $requestData,
            'data'     => preparePaymentData($requestData['orderId'], $rawResult['price'], null, 'iyzico')
        ];
        // Send data to process response
        paymentResponse($paymentResponseData);
    }

// Check Paypal payment process
} else if ($requestData['paymentOption'] == 'paypal') {
    // Get instance of paypal 
    $paypalIpnResponse  = new PaypalIpnResponse();

    // fetch paypal payment data
    $paypalIpnData = $paypalIpnResponse->getPaypalPaymentData();
    $rawData = json_decode($paypalIpnData, true);

    // Note : IPN and redirects will come here
    // Check if payment status exist and it is success
    if (isset($requestData['payment_status']) and $requestData['payment_status'] == "Completed") {

        // Then create a data for success paypal data
        $paymentResponseData = [
            'status'    => true,
            'rawData'   => (array) $paypalIpnData,
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], $rawData['txn_id'], 'paypal')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    // Check if payment not successfull    
    } else {
        // Prepare payment failed data
        $paymentResponseData = [
            'status'   => false,
            'rawData'  => [],
            'data'     => preparePaymentData($rawData['invoice'], $rawData['payment_gross'], null, 'paypal')
        ];
        // Send data to payment response function for further process
        paymentResponse($paymentResponseData);
    }

// Check Paystack payment process
} else if ($requestData['paymentOption'] == 'paystack') {

    $requestData = json_decode($requestData['response'], true);
    
    // Check if status key exists and payment is successfully completed
    if (isset($requestData['status']) and $requestData['status'] == "success") {
        // Create data for payment success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];
        // Send data to payment response for further process
        paymentResponse($paymentResponseData);
    // If paystack payment is failed    
    } else {
        // Prepare data for failed payment 
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($requestData['data']['reference'], $requestData['data']['amount'], $requestData['data']['reference'], 'paystack')
        ];
        // Send data to payment response to further process
        paymentResponse($paymentResponseData);
    }

// Check Stripe payment process
} else if ($requestData['paymentOption'] == 'stripe') {

    $stripeResponse = new StripeResponse();

    $stripeData = $stripeResponse->retrieveStripePaymentData($requestData['session_id']);
    
    // Check if payment charge status key exist in stripe data and it success
    if (isset($stripeData['status']) and $stripeData['status'] == "succeeded") {
        // Prepare data for success
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($stripeData->charges->data[0]['balance_transaction'], $stripeData->amount, $stripeData->charges->data[0]['balance_transaction'], 'stripe')
        ];
        
    // Check if stripe data is failed    
    } else {
        // Prepare failed payment data
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $stripeData,
            'data'     => preparePaymentData($requestData['orderId'], $stripeData->amount, null, 'stripe')
        ];
    }

    // Send data to payment response for further process
    paymentResponse($paymentResponseData);

// Check Razorpay payment process
} else if ($requestData['paymentOption'] == 'razorpay') {
    $orderId = $requestData['orderId'];
    
    $requestData = json_decode($requestData['response'], true);
    
    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'captured') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['id'], 'razorpay')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'authorize-net') {
    $orderId = $requestData['order_id'];
    
    $requestData = json_decode($requestData['response'], true);
    
    // Check if razorpay status exist and status is success
    if (isset($requestData['status']) and $requestData['status'] == 'success') {
        // prepare payment data
        $paymentResponseData = [
            'status'   => true,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    // razorpay status is failed
    } else {
        // prepare payment data for failed payment
        $paymentResponseData = [
            'status'   => false,
            'rawData'   => $requestData,
            'data'     => preparePaymentData($orderId, $requestData['amount'], $requestData['transaction_id'], 'authorize-net')
        ];
        // send data to payment response
        paymentResponse($paymentResponseData);
    }
} else if ($requestData['paymentOption'] == 'bitpay') {
    // prepare payment data
    $paymentResponseData = [
        'status'   => true,
        'rawData'  => $requestData,
        'data'     => preparePaymentData($requestData['orderId'], $requestData['amount'], $requestData['orderId'], 'bitpay')
    ];
    // send data to payment response
    paymentResponse($paymentResponseData);
} else if ($requestData['paymentOption'] == 'bitpay-ipn') {
    $bitpayResponse = new BitPayResponse;
    $rawPostData = file_get_contents('php://input');
    $ipnData = $bitpayResponse->getBitPayPaymentData($rawPostData);
    if ($ipnData['status'] == 'success') {
        // code here
    } else {
        // code here
    }
}

/*
 * This payment used for get Success / Failed data for any payment method.
 *
 * @param array $paymentResponseData - contains : status and rawData
 *
 */
function paymentResponse($paymentResponseData) {
    // payment status success
    if ($paymentResponseData['status']) {

        // Show payment success page or do whatever you want, like send email, notify to user etc
        header('Location: '. getAppUrl('payment-success.php'));        

    } else {        
        // Show payment error page or do whatever you want, like send email, notify to user etc
        header('Location: '. getAppUrl('payment-failed.php'));
    }
}

/*
* Prepare Payment Data.
*
* @param array $paymentData
*
*/
function preparePaymentData($orderId, $amount, $txnId, $paymentGateway) {
    return [
        'order_id'              => $orderId,
        'amount'                => $amount,
        'payment_reference_id'  => $txnId,
        'payment_gatway'        => $paymentGateway
    ];
}
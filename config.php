<?php 

$techAppConfig = [

    /* Base Path of app
    ------------------------------------------------------------------------- */
    'base_url' =>  'Your base URL to example/ folder',

    'payments' => [
        /* Gateway Configuration key
        ------------------------------------------------------------------------- */
        'gateway_configuration' => [
            'paypal' => [
                'enable'                        => true,      
                'testMode'                      => true, //test mode or product mode (boolean, true or false)
                'gateway'                       => 'Paypal', //payment gateway name
                'paypalSandboxBusinessEmail'        => 'Enter Paypal Sandbox Email', //paypal sandbox business email
                'paypalProductionBusinessEmail'     => 'Enter Paypal Business Email', //paypal production business email
                'currency'                  => 'USD', //currency
                'currencySymbol'              => '$',
                'paypalSandboxUrl'          => 'https://www.sandbox.paypal.com/cgi-bin/webscr', //paypal sandbox test mode Url
                'paypalProdUrl'             => 'https://www.paypal.com/cgi-bin/webscr', //paypal production mode Url
                'notifyIpnURl'              => 'payment-response.php', //paypal ipn request notify Url
                'cancelReturn'              => 'payment-response.php', //cancel payment Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => []
            ],
            'paytm' => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Paytm', //payment gateway name
                'currency'                  => 'INR', //currency
                'currencySymbol'              => '₹',
                'paytmMerchantTestingMidKey'       => 'Enter your Test Mid Key', //paytm testing Merchant Mid key
                'paytmMerchantTestingSecretKey'    => 'Enter your Test Secret Key', //paytm testing Merchant Secret key
                'paytmMerchantLiveMidKey'       => 'Enter your Live Mid Key', //paytm live Merchant Mid key
                'paytmMerchantLiveSecretKey'    => 'Enter your Live Secret Key', //paytm live Merchant Secret key
                'industryTypeID'            => 'Retail', //industry type
                'channelID'                 => 'WEB', //channel Id
                'website'                   => 'WEBSTAGING', 
                'paytmTxnUrl'               => 'https://securegw-stage.paytm.in/theia/processTransaction', //paytm transaction Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful or cancel payment
                'privateItems'              => [
                                                'paytmMerchantTestingSecretKey',
                                                'paytmMerchantLiveSecretKey'
                                            ]
            ],
            'instamojo' => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Instamojo', //payment gateway name
                'currency'                  => 'INR', //currency
                'currencySymbol'              => '₹',
                'sendEmail'                 => false, //send mail (true or false)
                'instamojoTestingApiKey'           => 'Enter your Test Api Key', // instamojo testing API Key
                'instamojoTestingAuthTokenKey'     => 'Enter your Test Auth Token Key', // instamojo testing Auth token Key
                'instamojoLiveApiKey'           => 'Enter your Live Api Key', // instamojo live API Key
                'instamojoLiveAuthTokenKey'     => 'Enter your Live Auth Token Key', // instamojo live Auth token Key
                'instamojoSandboxRedirectUrl'   => 'https://test.instamojo.com/api/1.1/', // instamojo Sandbox redirect Url
                'instamojoProdRedirectUrl'      => 'https://www.instamojo.com/api/1.1/', // instamojo Production mode redirect Url
                'webhook'                   => 'http://instamojo.com/webhook/', // instamojo Webhook Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                                                'instamojoTestingApiKey',
                                                'instamojoTestingAuthTokenKey',
                                                'instamojoLiveApiKey',
                                                'instamojoLiveAuthTokenKey',
                                                'instamojoSandboxRedirectUrl',
                                                'instamojoProdRedirectUrl'
                                            ]
            ],
            'paystack' => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Paystack', //payment gateway name
                'currency'                  => 'NGN', //currency
                'currencySymbol'              => '₦',
                'paystackTestingSecretKey'         => 'Enter your Test Secret Key', //paystack testing secret key
                'paystackTestingPublicKey'         => 'Enter your Test Publish Key', //paystack testing public key
                'paystackLiveSecretKey'         => 'Enter your Live Secret Key', //paystack live secret key
                'paystackLivePublicKey'         => 'Enter your Live Publish Key', //paystack live public key
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                                                'paystackTestingSecretKey',
                                                'paystackLiveSecretKey'
                                            ]
            ],
            'stripe'    => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Stripe', //payment gateway name
                'locale'                    => 'auto', //set local as auto
                'allowRememberMe'           => false, //set remember me ( true or false)
                'currency'                  => 'USD', //currency
                'currencySymbol'              => '$',
                'stripeTestingSecretKey'    => 'Enter your Test Secret Key', //Stripe testing Secret Key
                'stripeTestingPublishKey'   => 'Enter your Test Publish Key', //Stripe testing Publish Key
                'stripeLiveSecretKey'       => 'Enter your Live Secret Key', //Stripe Secret live Key
                'stripeLivePublishKey'      => 'Enter your Live Publish Key', //Stripe live Publish Key
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                                                'stripeTestingPublishKey',
                                                'stripeLivePublishKey'
                                            ]
            ],
            'razorpay'    => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Razorpay', //payment gateway name
                'merchantname'              => 'John', //merchant name
                'themeColor'                => '#4CAF50', //set razorpay widget theme color
                'currency'                  => 'INR', //currency
                'currencySymbol'              => '₹',
                'razorpayTestingkeyId'      => 'Enter your Test Api Key', //razorpay testing Api Key
                'razorpayTestingSecretkey'  => 'Enter your Test Secret Key', //razorpay testing Api Secret Key
                'razorpayLivekeyId'         => 'Enter your Live Api Key', //razorpay live Api Key
                'razorpayLiveSecretkey'     => 'Enter your Live Secret Key', //razorpay live Api Secret Key
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                                                'razorpayTestingSecretkey',
                                                'razorpayLiveSecretkey'
                                            ]
            ],
            'iyzico'    => [
                'enable'                    => true,
                'testMode'                  => true, //test mode or product mode (boolean, true or false) 
                'gateway'                   => 'Iyzico', //payment gateway name
                'conversation_id'           => 'CONVERS' . uniqid(), //generate random conversation id
                'currency'                  => 'TRY', //currency
                'currencySymbol'              => '₺',
                'subjectType'               => 1, // credit
                'txnType'                   => 2, // renewal
                'subscriptionPlanType'      => 1, //txn status
                'iyzicoTestingSecretkey'    => 'Enter your Test Secret Key', //iyzico testing Secret Key
                'iyzicoLiveApiKey'          => 'Enter your Live Api Key', //iyzico live Api Key
                'iyzicoLiveApiKey'          => 'Enter your Live Api Key', //iyzico live Api Key
                'iyzicoLiveSecretkey'       => 'Enter your Live Secret Key', //iyzico live Secret Key
                'iyzicoSandboxModeUrl'      => 'https://sandbox-api.iyzipay.com', //iyzico Sandbox test mode Url
                'iyzicoProductionModeUrl'   => 'https://api.iyzipay.com', //iyzico production mode Url
                'callbackUrl'               => 'payment-response.php', //callback Url after payment successful
                'privateItems'              => [
                                                'iyzicoTestingApiKey',
                                                'iyzicoTestingSecretkey',
                                                'iyzicoLiveApiKey',
                                                'iyzicoLiveSecretkey'
                                            ]
            ],
            'authorize-net'    => [
                'enable'                         => true,
                'testMode'                       => true, //test mode or product mode (boolean, true or false) 
                'gateway'                        => 'Authorize.net', //payment gateway name
                'reference_id'                   => 'REF' . uniqid(), //generate random conversation id
                'currency'                       => 'USD', //currency
                'currencySymbol'                 => '$',
                'type'                           => 'individual',
                'txnType'                        => 'authCaptureTransaction',
                'authorizeNetTestApiLoginId'     => 'Your Test API Login Id', //authorize-net testing Api login id
                'authorizeNetTestTransactionKey' => 'Your Test Transaction Key', //Authorize.net testing transaction key
                'authorizeNetLiveApiLoginId'     => 'Your Live API Login Id', //Authorize.net live Api login id
                'authorizeNetLiveTransactionKey' => 'Your Live Transaction Key', //Authorize.net live transaction key
                'callbackUrl'                    => 'payment-response.php', //callback Url after payment successful
                'privateItems'                  => [
                                                    'authorizeNetTestApiLoginId',
                                                    'authorizeNetTestTransactionKey',
                                                    'authorizeNetLiveApiLoginId',
                                                    'authorizeNetLiveTransactionKey'
                                                ]
            ],
            'bitpay'    => [
                'enable'                        => true,
                'testMode'                      => true, //test mode or product mode (boolean, true or false) 
                'notificationEmail'             => 'nikhil@yesteamtech.com', // Merchant Email
                'gateway'                       => 'BitPay', //payment gateway name
                'currency'                      => 'USD', //currency
                'currencySymbol'                => '$', //currency Symbol
                'password'                      => 'LivelyWorks', // Password for "EncryptedFilesystemStorage"
                'pairingCode'                   => 'Pairing Code', // Your pairing Code
                'pairinglabel'                  => 'Pairing Label', // Your Pairing Label
                'callbackUrl'                   => 'payment-response.php', //callback Url after payment successful
                'privateItems'                  => ['pairingCode', 'pairinglabel', 'password']
            ]
        ],
    ],

];

return compact("techAppConfig");
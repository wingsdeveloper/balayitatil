<?php

return [
	'baseUrl'       => env( 'IYZIPAY_BASE_URL', 'https://sandbox-api.iyzipay.com' ),
	'apiKey'        => env( 'IYZIPAY_API_KEY', 'sandbox-Chp0DSieltgp3kSQNQvy5hRTF3W2uu1c' ),
	'secretKey'     => env( 'IYZIPAY_SECRET_KEY', 'sandbox-F5uT9fVkPJFpLlo2jdgMJmk1RQEI4nXF' ),
	'billableModel' => 'App\PossibleCustomer'
    /*https://sandbox-merchant.iyzipay.com/dashboard giris bilgisi sandbox*/
];

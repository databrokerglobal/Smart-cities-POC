<?php

define ('WYRE_API_KEY',      'AK-3UE84YYT-TJ347NL7-9N9DMBT4-P2BTCY92');
define ('WYRE_SECRET_KEY',   'SK-HXEBE2G3-YGHMA2BN-FXEVPXUZ-REWV4RA3'); 
define ('WYRE_ACCOUNT_ID',   'AC_9RUNRP9UW38'); 
define ('WYRE_API_URL',     'https://api.testwyre.com');  // PROD https://api.sendwyre.com TEST - https://api.testwyre.com


//Transak Production Details
define ('TRANSAK_ENV',      'PRODUCTION'); // STAGING/PRODUCTION
define ('TRANSAK_API_KEY',      '5fb07952-8688-4d53-b733-7679e5ad7a98');
define ('TRANSAK_SECRET_KEY',   'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJBUElfS0VZIjoiNWZiMDc5NTItODY4OC00ZDUzLWI3MzMtNzY3OWU1YWQ3YTk4IiwiaWF0IjoxNjI5OTY1NjMyfQ.X949Il4iMkltilZWcg639gQJosMRHDkioGi73y3Ymy4'); 
define ('TRANSAK_WALLET_ADDRESS',   '0xfc6b0e0C50837f8A5785A3D03d4323D4cF7d1118'); 
define ('TRANSAK_PAYMENT_URL',     'https://global.transak.com');  // PROD https://global.transak.com Staging - https://staging-global.transak.com

//Transak Staging Details
/* define ('TRANSAK_ENV',      'STAGING');
define ('TRANSAK_API_KEY',      'e3432c3b-8273-4d1d-b843-10157f30f9a7');
define ('TRANSAK_SECRET_KEY',   'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJBUElfS0VZIjoiZTM0MzJjM2ItODI3My00ZDFkLWI4NDMtMTAxNTdmMzBmOWE3IiwiaWF0IjoxNjI5OTY1NjMyfQ.DzRP_71f3EKmpRxhV_YgwlYAvkxHwg5dZ9zxMxf3qnk'); 
define ('TRANSAK_WALLET_ADDRESS',   '0xfc6b0e0C50837f8A5785A3D03d4323D4cF7d1118'); 
define ('TRANSAK_PAYMENT_URL',     'https://staging-global.transak.com'); */

return [

      /*
    |--------------------------------------------------------------------------
    | DXS API URL
    |--------------------------------------------------------------------------    
    */

    /* 'dxsapiurl' => env('DXS_API_URL', 'https://databroker-dxs-beta.herokuapp.com'),
    'dxsapikey' => env('DXS_API_KEY', 'rdfjwey0ccvrbud50qmo'), */

    'dxsapiurl' => env('DXS_API_URL', 'https://databroker-dxs-dev.herokuapp.com'),
    'dxsapikey' => env('DXS_API_KEY', 'cyq4chc27soce3p5dnwe'),
    
    

    /* 'dxsapiurl' => env('DXS_API_URL', 'https://databroker-dxs-prod.herokuapp.com'),
    'dxsapikey' => env('DXS_API_KEY', 'wragk1vmd1u3nlp5cvgf'), */

     /*
    |--------------------------------------------------------------------------
    | AZUR WORKFLOW API URL
    |--------------------------------------------------------------------------    
    */

    'azure_workflow_api_url' => env('AZUR_API_URL', 'https://prod-107.westeurope.logic.azure.com:443/workflows'),
    
];
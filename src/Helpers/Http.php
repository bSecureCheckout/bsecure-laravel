<?php

namespace bSecure\UniversalCheckout\Helpers;

class Http
{
    static $RequestHeaders = [
        'locale'        =>  'x-locale',
        'currency'      =>  'x-currency',
        'deviceType'    =>  'x-device-type',
        'osVersion'     =>  'x-os-version',
        'appVersion'    =>  'x-app-version',
        'accessToken'   =>  'x-access-token'
    ];

    static $CurlContentTypes = [
        'JSON'                  =>  'Application/json',
        'MultiPartFormData'     =>  'Multipart/form-data'
    ];

    //in case of successful create, read, update, delete & any successful operation
    const SUCCESS = "success";

    //in case of operational or process failure
    const BAD_REQUEST = "bad_request";

    //in case of authentication failure, trying to access any protected route with expired or no API token
    const UNAUTHORISED = "unauthorised";

    //in case of validation failure
    const INPROCESSABLE = "inprocessable";

    static $Codes = [
        self::SUCCESS       => 200,
        self::BAD_REQUEST   => 400,
        self::UNAUTHORISED  => 401,
        self::INPROCESSABLE => 422
    ];

    public static function getApiPossibleCodes(){
        return array_values( self::$Codes );
    }

    public static function getIpDetails($ip)
    {
        return [
            'country_name' => 'Pakistan'
        ];

        $accessKey = env('IPSTACK_API_KEY');
        $url = env('IPSTACK_URL') . $ip . '?access_key=' . $accessKey;
        return Helper::apiRequest( 'GET',$url);
    }
}

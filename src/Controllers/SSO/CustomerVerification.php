<?php

namespace bSecure\UniversalCheckout\Controllers\SSO;

use App\Http\Controllers\Controller;


//Helper
use bSecure\UniversalCheckout\Helpers\AppException;
use bSecure\UniversalCheckout\Helpers\ApiResponseHandler;
use bSecure\UniversalCheckout\Helpers\Helper;

//Facade
use Validator;

class CustomerVerification extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function verifyCustomer($auth_code)
    {
        try {
            $validationErrors = $this->_checkForValidationRule( $auth_code );

            if( count( $validationErrors ) > 0 )
            {
                return ApiResponseHandler::validationError( $validationErrors );
            }

            $ssoCustomerProfile = $this->createSSOProfileStructure($auth_code);

            $ssoResponse = Helper::customerProfile($ssoCustomerProfile);

            if($ssoResponse['error'])
            {
                return ApiResponseHandler::failure($ssoResponse['message']);
            }else{
                $response = $ssoResponse['body'];
                return ApiResponseHandler::success($response, trans('bSecure::messages.customer.verification.success'));
            }

        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.customer.verification.failure'), $e->getTraceAsString());
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 27-November-2020
     */
    private function _checkForValidationRule($auth_code)
    {
        $errors = [];

        if( empty($auth_code) )
        {
            $errors[] = trans('bSecure::messages.validation.auth_code.required');
        }

        return $errors;
    }

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    private function createSSOProfileStructure($auth_code)
    {
        $sso_client = [];

        $sso_client['code'] = $auth_code;

        return $sso_client;
    }

}

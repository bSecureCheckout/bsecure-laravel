<?php

namespace bSecure\UniversalCheckout\Controllers\SSO;

use App\Http\Controllers\Controller;


//Helper
use bSecure\UniversalCheckout\Helpers\AppException;
use bSecure\UniversalCheckout\Helpers\Constant;
use bSecure\UniversalCheckout\Helpers\ApiResponseHandler;
use bSecure\UniversalCheckout\Helpers\Helper;

//Facade
use Validator;

class VerifyClientController extends Controller
{

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public function verifyClient($state,$appType)
    {
        try {

            $validationErrors = $this->_checkForValidationRule( $state );

            if( count( $validationErrors ) > 0 )
            {
                return ApiResponseHandler::validationError( $validationErrors );
            }


            $ssoPayload = $this->createSSODataStructure($state);

            if($appType == Constant::APP_TYPE['checkout'])
            {
                $auth_url = $this->_createAuthenticationURL($ssoPayload);
                $response = [
                  'redirect_url' => $auth_url
                ];
                return ApiResponseHandler::success($response, trans('bSecure::messages.sso_sco.success'));
            }
            else if ($appType == Constant::APP_TYPE['sdk'])
            {
                $ssoResponse = Helper::verifyClient($ssoPayload);
                if($ssoResponse['error'])
                {
                    return ApiResponseHandler::failure($ssoResponse['message']);
                }else{
                    $response = $ssoResponse['body'];
                    return ApiResponseHandler::success($response, trans('bSecure::messages.sso_sco.success'));
                }
            }else{
                return ApiResponseHandler::failure('Invalid application type', []);
            }

        } catch (\Exception $e) {
            return ApiResponseHandler::failure(trans('bSecure::messages.sso_sco.failure'), $e->getTraceAsString());
        }
    }

    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    private function createSSODataStructure($state)
    {
        $sso_client = [];

        $sso_client['client_id'] = config('bSecure.client_id');
        $sso_client['scope'] = "profile";
        $sso_client['response_type'] = "code";
        $sso_client['state'] = $state;

        return $sso_client;
    }

    /**
     * Author: Sara Hasan
     * Date: 27-November-2020
     */
    private function _createAuthenticationURL($sso_client)
    {
        $login_app_url = Constant::LOGIN_REDIRECT_URL;

        $client_id = $sso_client['client_id'];
        $scope = $sso_client['scope'];
        $response_type = $sso_client['response_type'];
        $state = $sso_client['state'];

        return $login_app_url.'?scope='.$scope.'&response_type='.$response_type.'&client_id='.$client_id.'&state='.$state;
    }


    /**
     * Author: Sara Hasan
     * Date: 27-November-2020
     */
    private function _checkForValidationRule($state )
    {
        $errors = [];


        if( empty($state) )
        {
            $errors[] = trans('bSecure::messages.validation.state.required');
        }

        return $errors;
    }
}

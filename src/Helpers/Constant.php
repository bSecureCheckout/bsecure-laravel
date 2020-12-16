<?php

namespace bSecure\UniversalCheckout\Helpers;

class Constant
{
    const HTTP_RESPONSE_STATUSES = [
      'success'             => 200,
      'failed'              => 400,
      'validationError'     => 422,
      'authenticationError' => 401,
      'authorizationError'  => 403,
      'serverError'         => 500,
    ];

    const AUTH_SERVER_URL = 'https://api-dev.bsecure.app/';

    const LOGIN_REDIRECT_URL = 'https://login-dev.bsecure.app/auth/sso';

    const API_VERSION = 'v1';

    const API_ENDPOINTS = [
      'oauth'               => Constant::API_VERSION . '/oauth/token',
      'create_order' => Constant::API_VERSION . '/order/create',
      'order_status' => Constant::API_VERSION . '/order/status',
      'manual_order_status_update' => Constant::API_VERSION . '/order/update-status',
      'verify_client' => Constant::API_VERSION . '/sso/verify-client',
      'customer_profile' => Constant::API_VERSION . '/sso/customer/profile',
    ];

    const APP_TYPE = [
      'checkout' => 1,
      'sdk' => 2,
    ];

    const OrderStatus = [
      'created'       => 1,
      'initiated'     => 2,
      'placed'        => 3,
      'awaiting-confirmation' => 4,
      'canceled' => 5,
      'expired' => 6,
      'failed' => 7
    ];
}

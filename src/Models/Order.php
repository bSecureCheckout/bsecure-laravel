<?php

namespace bSecure\UniversalCheckout\Models;

use bSecure\UniversalCheckout\Models\Merchant;
use bSecure\UniversalCheckout\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public static $validationRules = [
        'createOrder' => [
            'order_id'                     => 'required',

            'shipment_method_name'                     => 'nullable|string',
            'shipment_charges'                     => 'nullable|numeric',

            'customer'                     => 'required',
            'customer.name'         => 'nullable|string|max:191',
            'customer.country_code' => 'nullable|string|min:2|max:3',
            'customer.phone_number' => 'nullable|string|min:10|max:10',
            'customer.email'        => 'nullable|email',
            'customer.auth_code'    => 'nullable|string',

            'products'                     => 'required',
            'products.*.id'                => 'required|string|min:1|max:100|not_in:0',
            'products.*.name'              => 'required|string',
            'products.*.sku'               => 'nullable|string|max:50',
            'products.*.quantity'          => 'required|integer|max:9999',
            'products.*.price'             => 'required|numeric|not_in:0',
            'products.*.sale_price'        => 'required|numeric',
            'products.*.image'             => 'nullable|url',
            'products.*.description'       => 'nullable|string',
            'products.*.short_description' => 'nullable|string',

            'products.*.product_options' => 'nullable',
            'products.*.product_options.*.id' => 'nullable|numeric',
            'products.*.product_options.*.name' => 'nullable|string',
            'products.*.product_options.*.value' => 'nullable',
            'products.*.product_options.*.value.name' => 'nullable|string',
            'products.*.product_options.*.value.price' => 'nullable|string',
        ],
    ];


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function createMerchantOrder($orderPayload)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Create Order API
                $order_response = Helper::createOrder($merchantAccessToken, $orderPayload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message'], 'exception' => $order_response['body']['exception']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.failure'), 'exception' => $e->getTraceAsString()];
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function getOrderStatus($order_ref)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Order Status Update API

                $payload = ['order_ref' => $order_ref];

                $order_response = Helper::orderStatus($merchantAccessToken, $payload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message'], 'exception' => $order_response['body']['exception']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }



    /**
     * Author: Sara Hasan
     * Date: 10-November-2020
     */
    public static function updateManualOrderStatus($payload)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Order Status Update API
                $order_response = Helper::manualOrderStatusUpdate($merchantAccessToken, $payload);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message'], 'exception' => $order_response['body']['exception']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }


    /**
     * Author: Sara Hasan
     * Date: 26-November-2020
     */
    public static function getMerchantStatus($order_ref)
    {
        try {
            $merchantToken = Merchant::getMerchantAccessToken();

            if ($merchantToken['error']) {
                return ['error' => true, 'message' => $merchantToken['message']];
            } else {
                $merchantAccessToken = $merchantToken['body'];
                // Call Create Order API
                $order_response = Helper::createOrder($merchantAccessToken, $order_ref);

                if ($order_response['error']) {
                    return ['error' => true, 'message' => $order_response['body']['message']];
                } else {
                    return $order_response;
                }
            }
        } catch (\Exception $e) {
            return ['error' => true, 'message' => trans('bSecure::messages.order.status.failure'), 'exception' => $e->getTraceAsString()];
        }
    }
}

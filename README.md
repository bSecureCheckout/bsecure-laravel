bSecure Checkout 
=========================
Pakistan's first universal checkout solution that is easy and simple to integrate on your e-commerce store. 

### About bSecure Checkout ##

It gives you an option to enable *universal-login*, *two-click checkout* and accept multiple payment method for your customers, as well as run your e-commerce store hassle free.\
It is built for *desktop*, *tablet*, and *mobile devices* and is continuously tested and updated to offer a frictionless payment experience for your e-commerce store.


### Installation
You can install the package via **composer**

`` composer require bSecure/bsecure-laravel``

**Prerequisites** 

>PHP 7.2.5 and above

**Dependencies**

>"guzzlehttp/guzzle": "^7.2"

## Usage

### Configuration Setup

By following a few simple steps, you can set up your **bSecure Checkout** and **Single-Sign-On**. 

#### Getting Your Credentials

1. Go to [Partners Portal](https://builder.bsecure.pk/)
2. [App Integration](https://builder.bsecure.pk/integration-sandbox) >> Sandbox / Live
3. Select Environment Type (Custom Integration)
4. Fill following fields:\
    a. *Store URL* its required in any case\
    b. *Login Redirect URL* Required for feature **Login with bSecure**\
    c. *Checkout Redirect URL* Required for feature **Pay with bSecure**\
    d. *Checkout Order Status webhook* Required for feature **Pay with bSecure**
5. Save your client credentials (Client ID and Client Secret)
6. Please make sure to keep credentials at safe place in your code


## bSecure Checkout

Add provider for bSecure checkout in app.php

`` bSecure\UniversalCheckout\CheckoutServiceProvider::class ``

Add alias

`` 'BsecureCheckout' => bSecure\UniversalCheckout\BsecureCheckout::class ``


#### Publish the language file.
  ``php artisan vendor:publish --provider="bSecure\UniversalCheckout\CheckoutServiceProvider"``

It will create a vendor/bSecure folder inside resources/lang folder. If you want to customize the error messages your can overwrite the file.

#### Publish the configuration file
  ``php artisan vendor:publish --provider="bSecure\UniversalCheckout\CheckoutServiceProvider" --tag="config"``

A file (bSecure.php) will be placed in config folder.

```
return [
  'client_id' => env('BSECURE_CLIENT_ID', ''),
  'client_secret' => env('BSECURE_CLIENT_SECRET',''),

  'environment' => env('BSECURE_ENVIRONMENT'),
];
```

### Examples

#### Create Order
To create an order you should have an order_id, customer and products object parameters that are to be set before creating an order.
##### Create Order Request Params:

###### Product Object:

Products object should be in below mentioned format:

```
'products' => 
      array (
        0 => 
            array (
              'id' => 'product-id',
              'name' => 'product-name',
              'sku' => 'product-sku',
              'quantity' => 0,
              'price' => 0,
              'sale_price' => 0,
              'image' => 'product-image',
              'description' => 'product-description',
              'short_description' => 'product-short-description',
              'product_options' =>  'product_options-object'
            ),
      ),
```

###### Product Options Object:

Products object should be in below mentioned format:
```
'product_options' =>  
    array (
      0 => array (
              'id' => 'option-id(numeric)',
              'name' => 'option-name',
              'value' => array (
                0 => array (
                        'name' => 'option-value-name',
                        'price' => 'option-value-price',
                     ),   
              ),
           ),   
    ),
```
###### Shipment Object

Shipment object should be in below mentioned format:

>1- If the merchant want his pre-specified shipment method then he should pass shipment method detail in below mentioned format:  
```
'shipment' => 
      array (
        'charges' => 'numeric',
        'method_name' => 'string'
      ),
```

###### Customer Object

Customer object should be in below mentioned format:

>1- If the customer has already signed-in via bSecure into your system and you have auth-code for the customer you can
just pass that code in the customer object no need for the rest of the fields.

>2- Since all the fields in Customer object are optional, if you don’t have any information about customer just pass the
empty object, or if you have customer details then your customer object should be in below mentioned format:
```
'customer' => 
      array (
        'name' => 'string',
        'email' => 'string',
        'country_code' => 'string',
        'phone_number' => 'string',
      ),
```

#### Create Order
```
use bSecure\UniversalCheckout\BsecureCheckout;
```

```
$order = new BsecureCheckout();

$order->setOrderId($orderId);
$order->setCustomer($customer);
$order->setCartItems($products);
$order->setShipmentDetails($shipment);

$result =  $order->createOrder();
return $result;
```

In response createOrder(), will return order expiry, checkout_url, order_reference and merchant_order_id.
```
array (
  'expiry' => '2020-11-27 10:55:14',
  'checkout_url' => 'bSecure-checkout-url',
  'order_reference' => 'bsecure-reference',
  'merchant_order_id' => 'your-order-id',
) 
```
>If you are using a web-solution then simply redirect the user to checkout_url
```
if(!empty($result['checkout_url']))
return redirect($result['checkout_url']); 
```
>If you have Android or IOS SDK then initialize your sdk and provide order_reference to it
```
if(!empty($result['order_reference']))
return $result['order_reference']; 
```
When order is created successfully on bSecure, you will be redirected to bSecure SDK or bSecure checkout app where you will process your checkout.


#### Callback on Order Placement
Once the order is successfully placed, bSecure will redirect the customer to the url you mentioned in “Checkout
redirect url” in your [environment settings](https://builder.bsecure.pk/) in Partners Portal, with one additional param “order_ref” in the query
string.

#### Order Updates
By using order_ref you received in the "**[Callback on Order Placement](#callback-on-order-placement)**" you can call below method to get order details.

```
use bSecure\UniversalCheckout\BsecureCheckout;
```

```
$order_ref = $order->order_ref;

$orderStatusUpdate = new BsecureCheckout();
$result =  $orderStatusUpdate->orderStatusUpdates($order_ref);
return $result;
```

#### Order Status Change Webhook
Whenever there is any change in order status or payment status, bSecure will send you an update with complete
order details (contents will be the same as response of *[Order Updates](https://github.com/bSecureCheckout/bsecure-laravel/tree/master#order-updates)*) on the URL you mentioned in *Checkout Order Status webhook* in your environment settings in Partners Portal. (your webhook must be able to accept POST request).


## bSecure Single Sign On (SSO)


Add provider for bSecure checkout and single-sign-on in app.php

`` bSecure\UniversalCheckout\SSOServiceProvider::class ``

Add alias

`` 'BsecureSSO' => bSecure\UniversalCheckout\BsecureSSO::class ``


### Publish the language file.
   ``php artisan vendor:publish --provider="bSecure\UniversalCheckout\SSOServiceProvider"``

It will create a vendor/bSecure folder inside resources/lang folder. If you want to customize the error messages your can overwrite the file.

### Publish the configuration file
  ``php artisan vendor:publish --provider="bSecure\UniversalCheckout\SSOServiceProvider" --tag="config"``

A file (bSecure.php) will be placed in config folder.

Before using bSecure SSO, you will also need to add credentials for the OAuth services your application utilizes. These credentials should be placed in your config/bSecure.php configuration file. For example:

```

return [
  'client_id' => env('BSECURE_CLIENT_ID', ''),
  'client_secret' => env('BSECURE_CLIENT_SECRET',''),

  'environment' => env('BSECURE_ENVIRONMENT'),
];
```

### Routing

Next, you are ready to authenticate users! You will need two routes: one for redirecting the user to the OAuth provider, and another for receiving the customer profile from the provider after authentication. We will access BsecureSSO using the BsecureSSO Facade:

### Authenticate Client
Client Authentication is of two type sdk and web client validation.

>If you are using a web-solution then use below method

```
use bSecure\UniversalCheckout\BsecureSSO;

$state = $requestData['state'];

$client = new BsecureSSO();
return $client->authenticateWebClient($state);

```

In response, authenticateWebClient will return redirect_url, then simply redirect the user to redirect_url
```
array (
  "redirect_url": "your-authentication-url"

)
```

>If you are using a sdk-solution then use below method
```
use bSecure\UniversalCheckout\BsecureSSO;

$state = $requestData['state'];

$client = new BsecureSSO();
return $client->authenticateSDKClient($state);

```

In response, authenticateSDKClient will return request_id, merchant_name and store_url which you have to pass it to your SDK.
```
array (
  "request_id": "your-request-identifier",
  "merchant_name": "builder-company-name",
  "store_url": "builder-store-url"
)
```

### Client Authorization
On Successful Authorization,\
bSecure will redirect to Login redirect url you provided when setting up environment in Partners portal, along
with two parameters in query string: **code** and **state**
```
eg: https://my-store.com/sso-callback?code=abc&state=xyz
```
code recieved in above callback is cutsomer's auth_code which will be further used to get customer profile.

#### Verify Callback
Verify the state you received in the callback by matching it to the value you stored in DB before sending the client authentication
request, you should only proceed if and only if both values match.

### Get Customer Profile
Auth_code recieved from **Client Authorization** should be passed to method below to get customer profile. 


```
use bSecure\UniversalCheckout\BsecureSSO;

$auth_code = $requestData['auth_code'];

$client = new BsecureSSO();
return $client->customerProfile($auth_code);

```

In response, it will return customer name, email, phone_number, country_code, address book.
```
array (
    'name' => 'customer-name',
    'email' => 'customer-email',
    'phone_number' => 'customer-phone-number',
    'country_code' => customer-phone-code,
    'address' => 
        array (
          'country' => '',
          'state' => '',
          'city' => '',
          'area' => '',
          'address' => '',
          'postal_code' => '',
        ),
)
```
### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Contributions

**"bSecure – Your Universal Checkout"** is open source software.

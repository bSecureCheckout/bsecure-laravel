<?php

return [
  'general' => [
    'failed' => 'Request Failed',
    'success' => 'Request Successful',
    'validation' => 'Validation Error',
    'crashed' => 'Something went wrong',
    'unauthenticated' => 'Authentication Failed',
    'unauthorized' => 'Authorization Failed',
  ],
  'client' => [
    'invalid' => 'Invalid client id or secret provided',
    'id' => [
      'invalid' => 'Invalid client id provided',
    ],
    'secret' => [
      'invalid' => 'Invalid client secret provided',
    ],
    'environment' => [
      'invalid' => 'Invalid environment or secret keys provided',
    ]
  ],
  'validation' => [
    'order_ref' => [
      'required' => 'Order reference field is required',
    ],
    'auth_code' => [
      'required' => 'Auth code field is required',
    ],
    'state' => [
      'required' => 'State field is required',
    ],
    'order_id' => [
      'required' => 'Order id field is required',
      'failure' =>   'Unable to set order id field. Try again later',
    ],
    'customer' => [
      'required' => 'Customer object is required',
      'failure' =>   'Unable to set customer object field. Try again later',
    ],
    'products' => [
      'required' => 'Products object is required',
      'failure' =>   'Unable to set products object field. Try again later',
    ],
    'order_status' => [
      'required' => 'Order status field is required',
      'not_matched' => 'Order status does not match with bSecure order statuses.',
    ],
  ],
  'order' => [
    'success' => 'Order placed successfully',
    'failure' => 'Unable to place order. Try again later',
    'status' => [
      'success' => 'Order status updated received',
      'failure' => 'Unable to receive order status update.',
      'updated' => [
        'success' => 'Order status updated successfully',
        'failure' => 'Unable to update order status.',
      ]
    ],
  ],
  'sso_sco' => [
    'success' => 'Third-party login succeeded.',
    'failure' => 'Third-party login failed, please check the connection with bSecure.',
  ],
  'customer' => [
    'verification' => [
      'success' => 'Customer verified',
      'failure' => 'Customer verification failed',
    ]
  ]

];
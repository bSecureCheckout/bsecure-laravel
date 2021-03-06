<?php

namespace bSecure\UniversalCheckout;

use Illuminate\Support\Facades\Facade;

/**
 * @see \bSecure\UniversalCheckout\Skeleton\SkeletonClass
 */
class SSOFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'universal-sso';
    }
}

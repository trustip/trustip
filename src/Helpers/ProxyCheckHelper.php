<?php

use Trustip\Trustip\ProxyCheck;

if (!function_exists('Trustip\Trustip\isIpProxy')) {
    /**
     * Check if an IP address is a proxy
     *
     * @param string $ip IP address to check
     * @return boolean
     */
    function isIpProxy($ip)
    {
        // Create an instance of the ProxyCheck class
        $proxyCheck = app()->make(ProxyCheck::class);
        // Check if the IP address is a proxy
        try {
            $result = $proxyCheck->check($ip);
            // return true if the IP address is a proxy
            // return false if the IP address is not a proxy
            return $result->data->is_proxy;
        } catch (\Exception$e) {
            // handle error here
            // return false if the check method throws an exception or returns an error
            return false;
        }
    }
}

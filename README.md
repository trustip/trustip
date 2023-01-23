# Trustip - VPN & Proxy Detection
A Laravel package for VPN & Proxy Detection by Trustip.io

## Installation
You can install the package via composer:

```sh
composer require trustip/trustip
```

You need to set `TRUSTIP_API_KEY` in your `.env` file before using the package. You can get the API key from [Trustip.io](https://trustip.io/)
```sh
TRUSTIP_API_KEY=your_api_key
```

You can publish the config file with:
```sh
php artisan vendor:publish --provider="Trustip\Trustip\Providers\TrustipServiceProvider" 
```

Or create the config file config/trustip.php and add this code:
```php
<?php

return [
    /*
     * The API key used to authenticate with the trustip API.
     *
     * You can get your API key from https://trustip.io
     */
    'api_key' => env('TRUSTIP_API_KEY'),
];

```

## Usage
You can use it as a dependency injection in Route or Controller
```php
use Trustip\Trustip\ProxyCheck;

Route::get('/check-ip', function (ProxyCheck $proxyCheck) {
    $ip = "127.0.0.1";
    try {
        $result = $proxyCheck->check($ip);
        return $result;
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
```
Or by using `Trustip` facade :
```php
use Trustip;

$result = Trustip::check('8.8.8.8');

```
After that, you should get an output similar to this:
```json
{
    "status":"success",
    "data": {
        "ip":"127.0.0.1",
        "is_proxy":true,
    }
}
```
If the IP is proxy the `is_proxy` will be `true` if not it will be `false` you can read more at [https://trustip.io/api-docs](https://trustip.io/api-docs)

If there's an error, the output will be similar to this:
```json
{
    "status":"error",
    "message":"Invalid IP address"
}
```

You can also use the `isIpProxy` helper function in your controllers or other classes:
> The `isIpProxy` will return false if the check method throws an exception or returns an error
```php
if (isIpProxy('127.0.0.1')) {
    // IP is a proxy
} else {
    // IP is not a proxy
}
```

## Exceptions
- `Trustip\Trustip\Exceptions\MissingApiKeyException` is thrown if the api key is not found in the env file.
- `Trustip\Trustip\Exceptions\InvalidIpAddressException` is thrown if the ip address passed to the check method is invalid

## Security
If you discover any security related issues, please email support@trustip.io instead of using the issue tracker.

## Credits
- [Trustip.io](https://trustip.io/)
- [All Contributors](../../contributors)

## License
The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

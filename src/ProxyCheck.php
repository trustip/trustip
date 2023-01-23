<?php

namespace Trustip\Trustip;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Trustip\Trustip\Exceptions\InvalidIpAddressException;
use Trustip\Trustip\Exceptions\MissingApiKeyException;

class ProxyCheck
{
    private $api_key;

    private const API_URL = "https://api.trustip.io/v1/check.php";

    /**
     * ProxyCheck constructor.
     *
     * @param string $api_key The API Key from trustip.io
     */
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * Check if an IP address is a proxy
     *
     * @param string|null $ip The IP address to check
     * @throws \Exception if the API returns an error status
     * @return object
     */
    public function check($ip)
    {
        // checking the api key
        if (empty($this->api_key)) {
            throw new MissingApiKeyException("Trustip API Key not found in the env file, please set it before using the package");
        }
        // check the IP address
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            throw new InvalidIpAddressException("Invalid IP address");
        }
        $client = new Client();
        try {
            $response = $client->get(self::API_URL, [
                'query' => [
                    'key' => $this->api_key,
                    'ip' => $ip,
                ],
            ]);
            //decode the json response and return it as an object
            return json_decode($response->getBody()->getContents());
            // check if the api returns an error status
            if ($result->status === 'error') {
                throw new \Exception($result->message);
            }
            return $result;
        } catch (RequestException $e) {
            // handle error here
            // return an object with 'status' and 'message' properties with the error message
            return (object) [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
    }
}

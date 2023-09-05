<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 *
 * @package     Mobipaid
 * @copyright   Copyright (c) 2020 Mobipaid
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Mobipaid\Mobipaid\Helper;

class Curl extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * class of http
     *
     * @var string
     */
    private $http;

    /**
     * class of logger
     *
     * @var string
     */
    private $logger;

    /**
     * class of curlFactory
     *
     * @var string
     */
    private $curlFactory;

    /**
     * [__construct description]
     *
     * @param object $context
     * @param object $curlFactory
     * @param object $logger
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\HTTP\Adapter\CurlFactory $curlFactory,
        \Mobipaid\Mobipaid\Helper\Logger $logger,
        \Magento\Framework\App\ProductMetadataInterface $productMetadata
    ) {
        parent::__construct($context);
        $this->curlFactory = $curlFactory;
        $this->logger = $logger;
        $this->productMetadata = $productMetadata;
    }

    /**
     * Get the current Magento version
     *
     * @return string
     */
    private function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Get a response from the gateway
     *
     * @param  boolean $isJsonDecoded
     * @return string | boolean
     */
    public function getResponse($isJsonDecoded = false)
    {
        $magentoVersion = $this->getMagentoVersion();

        if (version_compare($magentoVersion, '2.4.6', '<')) {
            $response = $this->http->read();
            $responseCode = \Zend_Http_Response::extractCode($response);
            $responseBody = \Zend_Http_Response::extractBody($response);
            $this->http->close();

            if ($responseCode == 200 || $responseCode == 202 || $responseCode == 400) {
                $this->logger->info(
                    'response from gateway : '.
                    json_encode($responseBody)
                );
                if ($isJsonDecoded) {
                    return json_decode($responseBody, true);
                }
                return $responseBody;

            } elseif ($responseCode == 422) {
                return json_decode($responseBody, true);
            }

            return false;
        } else {
            $response = $this->http->send();
            $responseCode = $response->getStatusCode();
            $responseBody = $response->getBody();

            if ($responseCode == 200 || $responseCode == 202 || $responseCode == 400) {
                $this->logger->info(
                    'response from gateway : ' .
                    json_encode($responseBody)
                );
                if ($isJsonDecoded) {
                    return json_decode($responseBody, true);
                }
                return $responseBody;

            } elseif ($responseCode == 422) {
                return json_decode($responseBody, true);
            }

            return false;
        }

    }

    /**
     * Send request to the gateway
     *
     * @param string $url
     * @param string $request
     * @param string $accessKey
     * @param string $method
     * @param boolean $isJsonDecoded
     * @return string | boolean
     */
    public function sendRequest($url, $request, $accessKey, $method = 'GET', $isJsonDecoded = true)
    {
        $magentoVersion = $this->getMagentoVersion();
        $request["cart_items"] = array_values(array_filter($request["cart_items"], function ($item) {
                return $item["unit_price"] != 0.0;
            }));

        if(version_compare($magentoVersion, '2.4.6', '<')){
            $headers = [
                    "Authorization:Bearer ".$accessKey
                ];

            $this->http = $this->curlFactory->create();
            $this->http->setConfig(['verifypeer' => false]);

            if ($method == 'POST') {
                array_push($headers, "content-type: application/json");
                $this->http->write(\Zend_Http_Client::POST, $url, $http_ver = '1.1', $headers, json_encode($request));
            } elseif ($method == 'PUT') {
                array_push($headers, "content-type: application/json");
                $this->http->write(\Zend_Http_Client::PUT, $url, $http_ver = '1.1', $headers, json_encode($request));
            } else {
                $this->http->write(\Zend_Http_Client::GET, $url, $http_ver = '1.1', $headers, json_encode($request));
            }
            return $this->getResponse($isJsonDecoded);
        }else{
            $headers = [
                "Authorization: Bearer " . $accessKey
            ];

            $this->http = new \Laminas\Http\Client();

            if ($method == \Laminas\Http\Request::METHOD_POST || $method == \Laminas\Http\Request::METHOD_PUT) {
                array_push($headers, "content-type: application/json");
                $httpMethod = $method == \Laminas\Http\Request::METHOD_POST ? \Laminas\Http\Request::METHOD_POST : \Laminas\Http\Request::METHOD_PUT;

                $this->http->setUri($url);
                $this->http->setHeaders($headers);
                $this->http->setMethod($httpMethod);
                $this->http->setRawBody(json_encode($request, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));

            } else {
                $this->http->setMethod(\Laminas\Http\Request::METHOD_GET);
                $this->http->setHeaders($headers);
                $this->http->setUri($url);
            }


            return $this->getResponse($isJsonDecoded);
        }
    }
}

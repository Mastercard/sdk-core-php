<?php

/*
 * Copyright 2016 MasterCard International.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 * Redistributions of source code must retain the above copyright notice, this list of
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of
 * conditions and the following disclaimer in the documentation and/or other materials
 * provided with the distribution.
 * Neither the name of the MasterCard International Incorporated nor the names of its
 * contributors may be used to endorse or promote products derived from this software
 * without specific prior written permission.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 * OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT
 * SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED
 * TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER
 * IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING
 * IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF
 * SUCH DAMAGE.
 *
 */

namespace MasterCard\Core;

use MasterCard\Core\Exception\ApiException;
use MasterCard\Core\Exception\InvalidRequestException;
use MasterCard\Core\Exception\AuthenticationException;
use MasterCard\Core\Exception\ObjectNotFoundException;
use MasterCard\Core\Exception\NotAllowedException;
use MasterCard\Core\Exception\SystemException;
use MasterCard\Core\ApiConfig;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ApiController {

    const HTTP_SUCCESS = 200;
    const HTTP_NO_CONTENT = 204;
    const HTTP_AMBIGUOUS = 300;
    const HTTP_REDIRECTED = 302;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;
    const HTTP_NOT_ALLOWED = 405;
    const HTTP_BAD_REQUEST = 400;

    /**
     * @ignore
     */
    public static $methodMap = array(
        'create' => 'POST',
        'delete' => 'DELETE',
        'list' => 'GET',
        'show' => 'GET',
        'update' => 'PUT'
    );
    protected $fullUrl = null;
    protected $baseUrl = null;
    protected $client = null;

    function __construct() {

        $this->checkState();


        $fullUrl = ApiConfig::getLiveUrl();
        if (ApiConfig::isSandbox()) {
            $fullUrl = ApiConfig::getSandboxUrl();
        }

        if (filter_var($fullUrl, FILTER_VALIDATE_URL) == FALSE) {
            throw new ApiException("fullUrl: '" . $fullUrl . "' is not a valid url");
        }

        $this->fullUrl = $fullUrl;
        $this->baseUrl = Util::normalizeUrl($fullUrl);
        $this->client = new Client();
    }

    /// <summary>
    /// Checks the state.
    /// </summary>
    private function checkState() {

        if (ApiConfig::getAuthentication() == null) {
            throw new ApiException("No ApiConfig::authentication has been configured");
        }

        if (filter_var(ApiConfig::getLiveUrl(), FILTER_VALIDATE_URL) == FALSE) {
            throw new ApiException("Invalid URL supplied for API_BASE_LIVE_URL");
        }


        if (filter_var(ApiConfig::getSandboxUrl(), FILTER_VALIDATE_URL) == FALSE) {
            throw new ApiException("Invalid URL supplied for API_BASE_SANDBOX_URL");
        }
    }

    private function removeForwardSlashFromTail($url) {
        return preg_replace('{/$}', '', $url);
    }

    private function appendToQueryString($s, $stringToAppend) {
        if (strpos($s, "?") == false) {
            $s .= "?";
        } else {
            $s .= "&";
        }

        $s .= $stringToAppend;

        return $s;
    }

    /**
     * @ignore
     */
    public function setClient($customClient) {
        $this->client = $customClient;
    }

    /**
     * @ignore
     */
    public function getUrl($action, $resourcePath, &$inputMap) {

        $queryParams = array();
               
        
        $url = "%s";
        $tmpUrl = Util::getReplacedPath($this->removeForwardSlashFromTail($this->fullUrl).$this->removeForwardSlashFromTail($resourcePath), $inputMap);
        array_push($queryParams, $tmpUrl);
        
        switch ($action) {
            case "read":
            case "update":
            case "delete":
                if (array_key_exists("id", $inputMap)) {
                    $url .= "/%s";
                    array_push($queryParams, $inputMap->get("id"));
                }
                break;
            case "list":
                foreach ($inputMap as $key => $value) {
                    $url = $this->appendToQueryString($url, "%s=%s");
                    array_push($queryParams, Util::urlEncode($key));
                    array_push($queryParams, Util::urlEncode($value));
                }

            default:
                break;
        }

        $url = $this->appendToQueryString($url, "Format=JSON");
        $url = vsprintf($url, $queryParams);
        
        return $url;
    }

    public function getRequest($url, $action, $inputMap, $headerMap) {
        $request = null;

        switch ($action) {
            case "create":
                $request = new Request("POST", $url, [], json_encode($inputMap));
                break;
            case "delete":
                $request = new Request("DELETE", $url);
                break;
            case "update":
                $request = new Request("PUT", $url, [], json_encode($inputMap));
                break;
            case "read":
                $request = new Request("GET", $url);
                break;
            case "list":
                $request = new Request("GET", $url);
                break;
        }

        $request = $request->withHeader("Accept", "application/json");
        $request = $request->withHeader("Content-Type", "application/json");
        $request = $request->withHeader("User-Agent", "Java-SDK/" . ApiConfig::VERSION);
        foreach ($headerMap as $key => $value) {
            $request = $request->withHeader($key, $value);    
        }
        $request = ApiConfig::getAuthentication()->signRequest($url, $request);

        return $request;
    }

    public function execute($action, $resourcePath, $headerList, $inputMap) {
        $headerMap = Util::subMap($inputMap, $headerList);
        $url = $this->getUrl($action, $resourcePath, $inputMap);
        $request = $this->getRequest($url, $action, $inputMap, $headerMap);

        try {
            $response = $this->client->send($request);
            $statusCode = $response->getStatusCode();
            $responseContent = $response->getBody()->getContents();
            if ($statusCode < self::HTTP_AMBIGUOUS) {
                if (strlen($responseContent) > 0) {
                    return json_decode($responseContent, true);
                } else {
                    return array();
                }
            } else {
                $this->handleException($response);
            }
        } catch (RequestException $ex) {
            if ($ex->hasResponse()) {
                $this->handleException($ex->getResponse());
            } else {
                throw new SystemException("An unexpected error has been raised: ".$ex->getMessage());
            }
        }
    }

    private function handleException($response) {
        $status = $response->getStatusCode();
        $bodyArray = json_decode($response->getBody()->getContents(), TRUE);
        print_r($bodyArray);        

        if ($status < 500) {
            switch ($status) {
                case self::HTTP_BAD_REQUEST:
                    throw new InvalidRequestException("Bad request", $status, $bodyArray);
                    break;
                case self::HTTP_REDIRECTED:
                    throw new InvalidRequestException("Unexpected response code returned from the API, redirect is happening.", $status, $bodyArray);
                    break;
                case self::HTTP_UNAUTHORIZED:
                    throw new AuthenticationException("You are not authorized to make this request. Invalid request signing.", $status, $bodyArray);
                    break;
                case self::HTTP_NOT_FOUND:
                    throw new ObjectNotFoundException("Object not found", $status, $bodyArray);
                    break;
                case self::HTTP_NOT_ALLOWED:
                    throw new NotAllowedException("Operation not allowed", $status, $bodyArray);
                    break;
                default:
                    throw new InvalidRequestException("Bad request", $status, $bodyArray);
                    break;
            }
        } else {
            throw new SystemException("Internal Server Error:", $status, $bodyArray);
        }
    }

}

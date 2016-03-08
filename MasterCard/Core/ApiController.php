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
    public $fullUrl = null;
    public $baseUrl = null;

    function __construct($basePath) {

        $this->checkState();

        if ($basePath == null || trim($basePath) == '' || strlen($basePath) == 0) {
            throw new ApiException("basePath cannot be empty");
        }

        $baseUrl = ApiConfig::API_BASE_LIVE_URL;
        if (ApiConfig::isSandbox()) {
            $baseUrl = ApiConfig::API_BASE_SANDBOX_URL;
        }

        $fullUrl = $baseUrl . $basePath;
        if (filter_var($fullUrl, FILTER_VALIDATE_URL) == FALSE) {
            throw new ApiException("fullUrl: '" . $fullUrl . "' is not a valid url");
        }

        $this->fullUrl = $fullUrl;
        $this->baseUrl = Util::normalizeUrl($fullUrl);
    }

    /// <summary>
    /// Checks the state.
    /// </summary>
    private function checkState() {

        if (ApiConfig::getAuthentication() == null) {
            throw new ApiException("No ApiConfig::authentication has been configured");
        }

        if (filter_var(ApiConfig::API_BASE_LIVE_URL, FILTER_VALIDATE_URL) == FALSE) {
            throw new ApiException("Invalid URL supplied for API_BASE_LIVE_URL");
        }


        if (filter_var(ApiConfig::API_BASE_SANDBOX_URL, FILTER_VALIDATE_URL) == FALSE) {
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
    public function getUrl($type, $action, $baseObjectInstance) {

        $queryParams = array();
        $url = "";

        $url .= "%s/%s";
        array_push($queryParams, $this->removeForwardSlashFromTail($this->fullUrl));

        $modifiedType = str_replace("{id}", "", $type);
        array_push($queryParams, $this->removeForwardSlashFromTail($modifiedType));

        switch ($action) {
            case "create":
                break;
            case "read":
            case "update":
            case "delete":
                if ($baseObjectInstance->containsKey("id")) {
                    $url .= "/%s";
                    array_push($queryParams, $baseObjectInstance->get("id"));
                }
                break;
            case "list":
                if ($baseObjectInstance != null && $baseObjectInstance->size() > 0) {

                    //arizzini: addding max
                    if ($baseObjectInstance->containsKey("max")) {
                        $url = $this->appendToQueryString($url, "max=%s");
                        array_push($queryParams, Util::urlEncode($baseObjectInstance->get("max")));
                    }

                    if ($baseObjectInstance->containsKey("offset")) {
                        $url = $this->appendToQueryString($url, "offset=%s");
                        array_push($queryParams, Util::urlEncode($baseObjectInstance->get("offset")));
                    }

                    if ($baseObjectInstance->containsKey("sorting")) {
                        if (is_array($baseObjectInstanceMap->get("sorting"))) {
                            foreach ($baseObjectInstanceMap->get("sorting") as $key => $value) {
                                $url = $this->appendToQueryString($url, "sorting[%s]=%s");
                                array_push($queryParams, Util::urlEncode($key));
                                array_push($queryParams, Util::urlEncode($value));
                            }
                        }
                    }

                    if ($baseObjectInstance->containsKey("filter")) {
                        if (is_array($baseObjectInstanceMap->get("filter"))) {
                            foreach ($baseObjectInstanceMap->get("filter") as $key => $value) {
                                $url = $this->appendToQueryString($url, "filter[%s]=%s");
                                array_push($queryParams, Util::urlEncode($key));
                                array_push($queryParams, Util::urlEncode($value));
                            }
                        }
                    }

//                    IEnumerator enumerator = objectMap.GetEnumerator ();
//                    while (enumerator.MoveNext ()) {
//                            DictionaryEntry entry = (DictionaryEntry)enumerator.Current;
//                            s = appendToQueryString (s, (parameters++)+"="+(parameters++));
//                            objectList.Add (getURLEncodedString (entry.Key.ToString ()));
//                            objectList.Add (getURLEncodedString (entry.Value.ToString ()));
//                    }
                }

            default:
                break;
        }

        $url = $this->appendToQueryString($url, "Format=JSON");
        $url = vsprintf($url, $queryParams);

        return $url;
    }

    public function getRequest($url, $action, $baseObjectInstance) {
        $request = null;

        switch ($action) {
            case "create":
                $request = new Request("POST", $url, [], json_encode($baseObjectInstance->getProperties()));
                break;
            case "delete":
                $request = new Request("DELETE", $url);
                break;
            case "update":
                $request = new Request("PUT", $url, [], json_encode($baseObjectInstance->getProperties()));
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
        $request = ApiConfig::getAuthentication()->signRequest($url, $request);

        return $request;
    }

    public function execure($type, $action, $baseObjectInstance) {
        $url = $this->getUrl($type, $action, $baseObjectInstance);
        $request = $this->getRequest($url, $action, $baseObjectInstance);


        try {
            $client = new Client();
            $response = $client->send($request);
            $statusCode = $response->getStatusCode();
            if ($statusCode < self::HTTP_AMBIGUOUS) {
                $responseContent = $response->getBody()->getContents();
                if (strlen($responseContent) > 0) {
                    return json_decode($response->getBody()->getContents(), true);
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
                throw new SystemException("An unexpected error has been raised.  Looks like there's something wrong at our end.");
            }
        }
    }

    private function handleException($response) {
        $status = $response->getStatusCode();
        $bodyArray = json_decode($response->getBody()->getContents());

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
            throw new SystemException("An unexpected error has been raised.  Looks like there's something wrong at our end.", $status, $bodyMessage);
        }
    }

}

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

namespace MasterCard\Core\Exception;

/**
 *
 * Base class for all API exceptions.
 *
 */
class ApiException extends \Exception
{

    protected $message;
    protected $rawErrorData;
    protected $httpStatus;
    protected $reasonCode;
    protected $source;
    
    private $http_status_codes = array(100 => "Continue", 101 => "Switching Protocols", 102 => "Processing", 200 => "OK", 201 => "Created", 202 => "Accepted", 203 => "Non-Authoritative Information", 204 => "No Content", 205 => "Reset Content", 206 => "Partial Content", 207 => "Multi-Status", 300 => "Multiple Choices", 301 => "Moved Permanently", 302 => "Found", 303 => "See Other", 304 => "Not Modified", 305 => "Use Proxy", 306 => "(Unused)", 307 => "Temporary Redirect", 308 => "Permanent Redirect", 400 => "Bad Request", 401 => "Unauthorized", 402 => "Payment Required", 403 => "Forbidden", 404 => "Not Found", 405 => "Method Not Allowed", 406 => "Not Acceptable", 407 => "Proxy Authentication Required", 408 => "Request Timeout", 409 => "Conflict", 410 => "Gone", 411 => "Length Required", 412 => "Precondition Failed", 413 => "Request Entity Too Large", 414 => "Request-URI Too Long", 415 => "Unsupported Media Type", 416 => "Requested Range Not Satisfiable", 417 => "Expectation Failed", 418 => "I'm a teapot", 419 => "Authentication Timeout", 420 => "Enhance Your Calm", 422 => "Unprocessable Entity", 423 => "Locked", 424 => "Failed Dependency", 424 => "Method Failure", 425 => "Unordered Collection", 426 => "Upgrade Required", 428 => "Precondition Required", 429 => "Too Many Requests", 431 => "Request Header Fields Too Large", 444 => "No Response", 449 => "Retry With", 450 => "Blocked by Windows Parental Controls", 451 => "Unavailable For Legal Reasons", 494 => "Request Header Too Large", 495 => "Cert Error", 496 => "No Cert", 497 => "HTTP to HTTPS", 499 => "Client Closed Request", 500 => "Internal Server Error", 501 => "Not Implemented", 502 => "Bad Gateway", 503 => "Service Unavailable", 504 => "Gateway Timeout", 505 => "HTTP Version Not Supported", 506 => "Variant Also Negotiates", 507 => "Insufficient Storage", 508 => "Loop Detected", 509 => "Bandwidth Limit Exceeded", 510 => "Not Extended", 511 => "Network Authentication Required", 598 => "Network read timeout error", 599 => "Network connect timeout error");

    /**
     * @ignore
     */
    function __construct($message, $status = null, $errorData = null) {
        
        parent::__construct();
        
        if (!empty($status) && array_key_exists((int)$status, $this->http_status_codes)) {
            $this->message = $this->http_status_codes[(int)$status];
        } else {
            $this->message = $message;
        }
                
        $this->httpStatus = $status;
        $this->reasonCode = null;
        $this->source = null;

        if (!empty($errorData)) {
            $smartMap = new \MasterCard\Core\Model\RequestMap();
            $smartMap->setAll($errorData);
            $this->rawErrorData = $smartMap;
            
            $errorDataCaseInsesitive = $this->parseMap($errorData);
            if (array_key_exists('errors', $errorDataCaseInsesitive) && array_key_exists('error', $errorDataCaseInsesitive['errors']))
            {
                $error = $errorDataCaseInsesitive['errors']['error'];
                if (!$this->isAssoc($error))
                {
                    //arizzini: this is a fix when multiple errors are returned.
                    $error = $error[0];
                }
                                
                if (array_key_exists('description', $error))
                {
                    $this->message = $error['description'];
                }
                if (array_key_exists('reasoncode', $error))
                {
                    $this->reasonCode = $error['reasoncode'];
                }
                if (array_key_exists('source', $error))
                {
                    $this->source = $error['source'];
                }
            }
        }
    }
    
    protected function isAssoc($arr)
    {
        return is_array($arr) && (array_keys($arr) !== range(0, count($arr) - 1));
    }
    
    /**
     * Returns a map of all error data returned by the API.
     * @return array a map containing API error data.
     */
    function getRawErrorData() {
        return $this->rawErrorData;
    }

    /**
     * Returns the HTTP status for the request.
     * @return string HTTP status code (or null if there is no status).
     */
    function getHttpStatus() {
        return $this->httpStatus;
    }
    
    /**
     * Returns unique reference for the API error.
     * @return string a reference (or null if there is no reference).
     */
    function getSource() {
        return $this->source;
    }

    /**
     * Returns an code for the API error.
     * @return string the error code.
     */
    function getReasonCode() {
        return $this->reasonCode;
    }

    /**
     * Returns a description of the error.
     * @return string Description of the error.
     */
    function describe() {
        return get_class($this) . ": \"" 
            . $this->getMessage() . "\" (htt_status: "
            . $this->getHttpStatus() . ", reason_code: "
            . $this->getReasonCode() . ", source: "
            . $this->getSource() . ")";
    }
    
    private function parseMap($map) {
        $result = array();
        foreach ($map as $key => $value) {
            if ($this->isAssoc($value)) {
                //this is a map
                $result[strtolower($key)] = $this->parseMap($value);
            } else if (is_array ($value)){
                //this is a list
                $result[strtolower($key)] = $this->parseList($value);
            } else {
                /// this is a simple value
                $result[strtolower($key)] = $value;
            }
        }
        return $result;
    }
    
    private function parseList($list) {
        $result = array();
        foreach ($list as $key => $value) {
            if ($this->isAssoc($value)) {
                $result[] = $this->parseMap($value);
            } else if (is_array ($value)) {
                $result[] = $this->parseList($value);
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }


}
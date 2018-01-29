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

use MasterCard\Core\Model\CaseInsensitiveMap;

/**
 *
 * Base class for all API exceptions.
 *
 */
class ApiException extends \Exception
{

    protected $message;
    
    protected $httpStatus;
    protected $reasonCode;
    protected $source;
    
    protected $rawErrorData;
    protected $error;
    protected $errors;
    
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
        
        $this->errors = array();
        $this->error = null;
        
        $this->parseRawErrorData($errorData);
        $this->parseErrors($errorData);
        $this->parseError(0);

        
    }


    public function getErrorSize() {
        return count($this->errors);
    }
    
    public function parseError($index) {
        if (!empty($this->errors) && $index >=0 && $index < $this->getErrorSize()) {
            $this->error = $this->errors[$index];
            $this->parseErrorMap();
        }
    }
    
    public function getError() {
        return $this->error;
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
            . $this->getMessage() . "\" (http_status: "
            . $this->getHttpStatus() . ", reason_code: "
            . $this->getReasonCode() . ", source: "
            . $this->getSource() . ")";
    }
    
    private function isAssoc($arr)
    {
        return is_array($arr) && (array_keys($arr) !== range(0, count($arr) - 1));
    }
    
    private function parseRawErrorData($errorData) {
        if ($this->isAssoc($errorData)) {
            $caseInsesitiveMap = new CaseInsensitiveMap();
            $caseInsesitiveMap->setAll($errorData);
            $this->rawErrorData = $caseInsesitiveMap;
        } else if (is_array ($errorData) && $this->isAssoc($errorData[0])){
            $caseInsesitiveMap = new CaseInsensitiveMap();
            $caseInsesitiveMap->setAll($errorData[0]);
            $this->rawErrorData = $caseInsesitiveMap;
        }
    }  
    
    private function parseErrors($errorData) {
        if (!empty($errorData)) {
            
            
            $errors = array();
            //arizzini: this takes care of the list returned in the response
            if ($this->isAssoc($errorData)) {
                $errors[] = $errorData;
            } else if (is_array ($errorData)){
                $errors = array_merge($errors, $errorData);
            } else {
                $errors[] = $errorData;
            }
            
            //arizzini: then we parse each invididual error into a 
            //          case insenstive map.
            foreach ($errors as $error) {
                $smartMap = new CaseInsensitiveMap();
                $smartMap->setAll($error);
                
                if ($smartMap->containsKey("errors.error.reasoncode")) {
//                    echo "contains errors.error.reasoncode";
                    $this->addError($smartMap->get("errors.error"));
                } else if ($smartMap->containsKey("errors.error[0].reasoncode")) {
//                    echo "contains errors.error[0].reasoncode";
                    $this->addError($smartMap->get("errors.error"));
                } else if ($smartMap->containsKey("errors[0].reasoncode")) {
//                    echo "errors[0].reasoncode";
                    $this->addError($smartMap->get("errors"));
                } else if ($smartMap->containsKey("reasoncode")) {
//                    echo "contains reasoncode";
                    $this->addError($smartMap->getBaseMapAsArray());
                } 
            }
        }
    }
    
    
    private function addError($error) {
        if ($this->isAssoc($error)) {
            $map = new CaseInsensitiveMap();
            $map->setAll($error);
            $this->errors[] = $map;
        } else if (is_array($error)) {
            foreach ($error as $item) {
                $map = new CaseInsensitiveMap();
                $map->setAll($item);
                $this->errors[] = $map;
            }
        }  
    }
    
    private function parseErrorMap() {
        if ($this->error->containsKey('description'))
        {
            $this->message = $this->error->get('description');
        }
        if ($this->error->containsKey('reasoncode'))
        {
            $this->reasonCode = $this->error->get('reasoncode');
        }
        if ($this->error->containsKey('source'))
        {
            $this->source = $this->error->get('source');
        }
    }
    
    
    


}
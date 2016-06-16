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

    protected $errorData;
    protected $status;
    protected $errorCode;
    protected $reference;

    /**
     * @ignore
     */
    function __construct($message, $status = null, $errorData = null) {
        parent::__construct($message);
        
//        echo "---ERROR: ".$message." \r\n";
//        print_r($errorData);
//        echo "\r\n";
        

        $this->status = $status;
        $this->errorData = $errorData;
        
        $this->errorCode = null;
        $this->reference = null;

        if ($errorData != null) {
            
            if (array_key_exists('Errors', $errorData) && array_key_exists('Error', $errorData['Errors']))
            {
                $error = $errorData['Errors']['Error'];
                if (!$this->isAssoc($error))
                {
                    //arizzini: this is a fix when multiple errors are returned.
                    $error = $error[0];
                }
                                
                if (array_key_exists('Description', $error))
                {
                    $this->message = $error['Description'];
                }
                if (array_key_exists('ReasonCode', $error))
                {
                    $this->message = $error['ReasonCode'];
                }
                if (array_key_exists('Source', $error))
                {
                    $this->message = $error['Source'];
                }
            }
        }
    }
    
    protected function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
    
    /**
     * Returns a map of all error data returned by the API.
     * @return array a map containing API error data.
     */
    function getErrorData() {
        return $this->errorData;
    }

    /**
     * Returns the HTTP status for the request.
     * @return string HTTP status code (or null if there is no status).
     */
    function getStatus() {
        return $this->status;
    }
    
    /**
     * Returns unique reference for the API error.
     * @return string a reference (or null if there is no reference).
     */
    function getReference() {
        return $this->reference;
    }

    /**
     * Returns an code for the API error.
     * @return string the error code.
     */
    function getErrorCode() {
        return $this->errorCode;
    }

    /**
     * Returns a description of the error.
     * @return string Description of the error.
     */
    function describe() {
        return get_class($this) . ": \"" 
            . $this->getMessage() . "\" (status: "
            . $this->getStatus() . ", error code: "
            . $this->getErrorCode() . ", reference: "
            . $this->getReference() . ")";
    }


}
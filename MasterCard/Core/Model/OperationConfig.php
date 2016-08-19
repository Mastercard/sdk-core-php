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

namespace MasterCard\Core\Model;

class OperationConfig {
    protected $resourcePath;
    protected $action;
    protected $queryParams;
    protected $headerParams;
    
    public function __construct($resourcePath, $action, $queryParams, $headerParams) {
        $this->resourcePath = $resourcePath;
        $this->action = $action;
        $this->queryParams = $queryParams;
        $this->headerParams = $headerParams;
    }
    
    /**
     * returns the resource path for this operation
     * @return type
     */
    public function getResourcePath() {
        return $this->resourcePath;
    }
    
    /**
     * returns the action for this operation
     * @return type
     */
    public function getAction() {
        return $this->action;
    }
    
    /**
     * return queryParams for this operation
     * @return type
     */
    public function getQueryParams() {
        return $this->queryParams;
    }
    
    
    /**
     * return headerParams for this operation
     * @return type
     */
    public function getHeaderParams() {
        return $this->headerParams;
    }

}
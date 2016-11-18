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

use \MasterCard\Core\Model\RequestMap;
use \MasterCard\Core\ApiController;

abstract class BaseObject extends RequestMap {

    
    protected static function getOperationConfig($operationUUID) {
        throw new \Exception("Not implemented");
    }

    protected static function getOperationMetadata() {
        throw new \Exception("Not implemented");
    }
    
       

    function __construct($baseMap = null) {
        if ($baseMap) {
            $this->setAll($baseMap);
        }
        
    }

    /**
     * @ignore
     */
    protected static function execute($operationUUID, $inputObject) {
        
        $operationConfig = $inputObject->getOperationConfig($operationUUID);
        $operationMetadata = $inputObject->getOperationMetadata();
        
        $apiController = new ApiController($operationMetadata->getApiVersion());
        
        $responseMap = $apiController->execute($operationConfig, $operationMetadata, $inputObject->getBaseMapAsArray());
        $returnObjectClass = get_class($inputObject);
        
        if ($operationConfig->getAction() == "list") {
            $returnObject = array();
            
            if (array_key_exists("list", $responseMap)) {
                $responseMap = $responseMap["list"];
            }
            
            foreach ($responseMap as $objectMap) {
                $baseMap = new RequestMap();
                $baseMap->setAll($objectMap);
                $returnObject[] = new $returnObjectClass($baseMap);
            }
            return $returnObject;
            
        } else {
            $baseMap = new RequestMap();
            $baseMap->setAll($responseMap);
            return new $returnObjectClass($baseMap);
        }
    }

}

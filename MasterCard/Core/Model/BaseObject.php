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

use \MasterCard\Core\Model\BaseMap;
use \MasterCard\Core\ApiController;

abstract class BaseObject extends BaseMap
{
    const BasePath = "";
    const ObjectType = "";
    
    abstract function getBasePath();
    abstract function getObjectType();
    
    function __construct($baseMap) {
        parent::setAll($baseMap->getProperties());
    }
        
    /**
     * @ignore
     */
    protected static function readObject($inputObject)
    {
        return self::execure("read", $inputObject);
    }
    
    
    /**
     * @ignore
     */
    protected static function listObjects($inputObject)
    {
        return self::execure("list", $inputObject);
    }

    /**
     * @ignore
     */
    protected static function createObject($inputObject)
    {
        return self::execure("create", $inputObject);
    }

    /**
     * @ignore
     */
    protected function updateObject($inputObject) {
        return self::execute ("update", $inputObject);
    }

    /**
     * @ignore
     */
    protected function deleteObject($inputObject) {
         return self::execute ("delete", $inputObject);
    }

    
    
    
    /**
     * @ignore
     */
    private static function execute($action, $inputObject)
    {
        $apiController = new ApiController($inputObject->getBasePath());
        $responseMap = $apiController->execure($inputObject->getObjectType(), $action, $inputObject);
        
        $baseMap = new BaseMap();
        $baseMap->setAll($responseMap);
        
        $returnObjectClass = get_class($inputObject);
        $returnObject = new $returnObjectClass($baseMap);
        
        return $returnObject;
    }
}


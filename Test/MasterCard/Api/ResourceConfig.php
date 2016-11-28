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

 namespace MasterCard\Api;

 use MasterCard\Core\ApiConfig;
 use MasterCard\Core\Model\Environment;


/**
 * 
 */
class ResourceConfig  {

    private static $override = null;
    private static $host = null;
    private static $context = null;
    private static $instance = null;




    private function __construct() {
//        $environment = ApiConfig::getEnvironment();
//        $this->setEnvironment($environment);
//        ApiConfig::addSDKConfig($this);
    }
    
    
    public static function getInstance()
    {
        if ( is_null( static::$instance ) )
        {
            static::$instance = new self();
        }
        return static::$instance;
    }

    public function getContext() {
        return static::$context;
    }

    public function getHost() {
        return  (static::$override!= null) ? static::$override : static::$host;
    }

    public function getVersion() {
        return "0.0.1";
    }
    
    
    public function setEnvironment($environment) {
        if (array_key_exists($environment, Environment::$MAPPING)) {
            $configArray = Environment::$MAPPING[$environment];
            static::$host = $configArray[0];
            static::$context = $configArray[1];
        } else {
            throw new \RuntimeException("Environment: $environment not found for sdk: ".get_class());
        }
    }
    
    public function clearOverride() {
        self::$override = null;
    }
    
    public function setOverride() {
        self::$override = "http://localhost:8081";
    }



}


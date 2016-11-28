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

use MasterCard\Core\Model\Environment;
use MasterCard\Core\Security\AuthenticationInterface;


class ApiConfig {

    private static $DEBUG = false;
    private static $AUTHENTICATION = null;
    private static $registeredInstances = array();
    private static $ENVIRONMENT = Environment::SANDBOX;
    
    
    /**
     * Sets the debug.
     * @param boolean $debug
     */
    public static function setDebug($debug)
    {
        static::$DEBUG = $debug;
    }
    
    
    /**
     * Sets get debug.
     */
    public static function isDebug()
    {
        return static::$DEBUG;
    }
    
    /**
     * Sets the sandbox.
     * @param boolean sandbox
     */
    public static function setSandbox($sandbox)
    {
        if ($sandbox == true) {
            static::$ENVIRONMENT = Environment::SANDBOX;
        } else {
            static::$ENVIRONMENT = Environment::PRODUCTION;
        }
        static::setEnvironment(static::$ENVIRONMENT);
    }


    /**
     * This method is used to set the SubDomain
     * @param type $subDomain
     */
    public static function setEnvironment($environment) {
        if (!empty($environment)) {
            foreach (array_values(static::$registeredInstances) as $instance) {
                $instance->setEnvironment($environment);
            }
            static::$ENVIRONMENT = $environment;
        } 
        
    }
    
    /**
     * This method is used to return the set environment
     * @return type
     */
    public static function getEnvironment() {
        return static::$ENVIRONMENT;
    }


    /**
     * This is used to add the SDKCOnfig to the APIConfig
     * so when the configuration changes the underline SDKConfig
     * are updated.
     * 
     * @param type $instance
     */
    public static function registerResourceConfig($instance) {
        $className = get_class($instance);
        if (!array_key_exists($className, static::$registeredInstances)){
            static::$registeredInstances['$className'] = $instance;
        }
    }
            
    
    public static function clearResourceConfig() {
        static::$registeredInstances = array();
    }

    /**
     * Sets the sandbox.
     * @param boolean sandbox
     */
    public static function setAuthentication(AuthenticationInterface $authentication)
    {
        static::$AUTHENTICATION = $authentication;
    }
    
    
    /**
     * Sets get debug.
     */
    public static function getAuthentication()
    {
        return static::$AUTHENTICATION;
    }
    
}
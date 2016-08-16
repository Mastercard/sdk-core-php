<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MasterCard\Api;

use MasterCard\Core\Model\RequestMap;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


abstract class BaseTest extends \PHPUnit_Framework_TestCase {
    
    protected static $logger = null;
    public static $responses = array();
    
    
    protected function setUp() {
        self::$logger = new Logger('BaseTest');
    }
    
    /**
     * 
     * @param type $name
     * @param type $response
     */
    public static function putResponse($name, $response) {
        BaseTest::$responses[$name] = $response;
    }

    /**
     * 
     * @param type $overrideValue
     * @return type
     */
    public static function resolveResponseValue($overrideValue) {


        $pos = strpos($overrideValue, ".");

        $name = substr($overrideValue, 0, $pos);
        $key = substr($overrideValue, $pos+1);

        if (array_key_exists($name, BaseTest::$responses)) {
            $response = BaseTest::$responses[$name];
            if ($response->containsKey($value)) {
                return $response->get($value);
            } else {
                self::$logger->addError("Value:'$value' is not found in the response");
            }
        }  else {
            self::$logger->addError("Name:'$name' is not found in the responses");
        }

        return null;
    }
    
    
    protected function customAssertValue($expected, $actual) {
        if (is_bool($actual)) {
            $this->assertEquals(boolval($expected), $actual);
        } else if (is_int($actual)) {
            $this->assertEquals(intval($expected), $actual);
        } else if (is_float($actual)) {
            $this->assertEquals(floatval($expected), $actual);
        } else {
            $this->assertEquals(strtolower($expected), strtolower($actual));
        }
    }
        
    
}
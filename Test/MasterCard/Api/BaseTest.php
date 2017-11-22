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
use PHPUnit\Framework\TestCase;


abstract class BaseTest extends TestCase {
    
    protected static $logger = null;
    public static $responses = array();
    public static $authentications = array();


    protected function setUp() {
        self::$logger = new Logger('BaseTest');
 
    }

    /**
     *
     * @param type $name
     * @param type $response
     */
    public static function putResponse($name, $response) {
        self::$responses[$name] = $response;
    }

    /**
     *
     * @param type $overrideValue
     * @return type
     */
    public static function resolveResponseValue($overrideValue) {

        //arizzini: if plain value, return it.
        if (substr( $overrideValue, 0, 4 ) === "val:") {
            return substr($overrideValue, 4, strlen($overrideValue)-4);
        } else {
            $pos = strpos($overrideValue, ".");
            $name = substr($overrideValue, 0, $pos);
            $key = substr($overrideValue, $pos+1);

            if (array_key_exists($name, BaseTest::$responses)) {
                $response = BaseTest::$responses[$name];
                if ($response->containsKey($key)) {
                    return $response->get($key);
                } else {
                     self::$logger->addError("Key:'$key' is not found in the response");
                }
            }  else {
                 self::$logger->addError("Example:'$name' is not found in the responses");
            }

            return null;
        }
    }

    protected function customAssertEqual($ignoreList, $response, $key, $expectedValue) {
        if (!in_array($key, $ignoreList)) {
            //not in the array so we need to test it.
            $this->customAssertValue($expectedValue, $response->get($key));
        }
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
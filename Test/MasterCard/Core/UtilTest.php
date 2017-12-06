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

use MasterCard\Core\Model\RequestMap;
use PHPUnit\Framework\TestCase;

class UtilTest extends TestCase{
    
    public function testNormalizeUrl() {
        $baseUrl = "http://php.net/manual/en/function.parse-url.php";
        $this->assertEquals($baseUrl, Util::normalizeUrl($baseUrl));

        $url2WithParams = "http://php.net/manual/en/function.parse-url.php?some=parameter&some1=parameter2";
        $this->assertEquals($baseUrl, Util::normalizeUrl($url2WithParams));

        $url2WithParams = "http://php.net/manual/en/function.parse-url.php?some=parameter&some1=parameter2";
        $this->assertEquals($baseUrl, Util::normalizeUrl($url2WithParams));
    }

    public function testNormalizeParameter() {

        $url = "http://php.net/manual/en/function.parse-url.php";
        $parameters = "some=parameter&some1=parameter2";
        $this->assertEquals($parameters, Util::normalizeParameters($url . "?" . $parameters, array()));

        $paramterArray = [ "paramNameFromArray1" => "paramValueFromArray1", "paramNameFromArray2" => "paramValueFromArray2"];

        $url = "http://php.net/manual/en/function.parse-url.php?some=parameter&some1=parameter2";
        $parameters = "paramNameFromArray1=paramValueFromArray1&paramNameFromArray2=paramValueFromArray2&some=parameter&some1=parameter2";
        $this->assertEquals($parameters, Util::normalizeParameters($url, $paramterArray));
    }

    public function testBase64Encode() {
        $this->assertEquals("cGFzc3dvcmQ=", Util::base64Encode("password"));
    }

    public function testSha1Encode() {
        $this->assertEquals("5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8", Util::sha1Encode("password"));
    }

    public function testUrlEncode() {
        $url = "http://php.net/manual/en/function.parse-url.php?some=parameter&some1=parameter2";
        $this->assertEquals("http%3A%2F%2Fphp.net%2Fmanual%2Fen%2Ffunction.parse-url.php%3Fsome%3Dparameter%26some1%3Dparameter2", Util::urlEncode($url));
    }
    
    public function testUri3986Encode()
    {
        $this->assertEquals("andrea%21andrea%2Aandrea%27andrea%28andrea%29", Util::uriRfc3986Encode("andrea!andrea*andrea'andrea(andrea)"));
    }
    
    
    public function testSubMap() {
        
        $inputMap = array(
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $keyList = array (
            'one',
            'three',
            'five'
        );
        
        $subMap = Util::subMap($inputMap, $keyList);
        
        $this->assertCount(3, $subMap);
        $this->assertEquals(1, $subMap['one']);
        $this->assertEquals(3, $subMap['three']);
        $this->assertEquals(5, $subMap['five']);
        
        $this->assertCount(2, $inputMap);
        $this->assertEquals(2, $inputMap['two']);
        $this->assertEquals(4, $inputMap['four']);
    }
    
    
    public function testGetReplacedPath() {
        
        $inputMap = array(
            'one' => 1,
            'two' => 2,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        $path = "http://localhost:8080/{one}/{two}/{three}/car";
        $result = Util::getReplacedPath($path, $inputMap);
        
        $this->assertEquals("http://localhost:8080/1/2/3/car", $result);
        $this->assertCount(2, $inputMap);
    }
    
//    public function testGetReplacedPathWithBaseMap() {
//        
//        $inputMap = new BaseMap();
//        $inputMap->set("one", 1)->set("two", 2)->set("three", 3)->set("four", 4)->set("five", 5);
//            
//        $path = "http://localhost:8080/{one}/{two}/{three}/car";
//        $result = Util::getReplacedPath($path, $inputMap);
//        
//        $this->assertEquals("http://localhost:8080/1/2/3/car", $result);
//        $this->assertEquals(2, count($inputMap));
//    }
    
}

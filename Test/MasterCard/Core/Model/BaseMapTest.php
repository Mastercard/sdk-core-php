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

use MasterCard\Core\Model\BaseMap;

class BaseMapTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $baseObject = new BaseMap();
        $baseObject->set("key1", "value1");
        
        $this->assertTrue($baseObject != NULL);
        $this->assertTrue($baseObject->containsKey("key1"));
        $this->assertEquals(1, $baseObject->size());
        $this->assertEquals("value1", $baseObject->get("key1"));
    }
    
    
    public function testNestedMap()
    {
        $baseObject = new BaseMap();
        $baseObject->set("key1.key2.key3", "value1");
        $baseObject->set("key1.key2.key4", "value2");
        
        
        $this->assertTrue($baseObject != NULL);
        
        $this->assertTrue($baseObject->containsKey("key1"));
        $this->assertTrue($baseObject->containsKey("key1.key2"));
        $this->assertTrue($baseObject->containsKey("key1.key2.key3"));
        $this->assertTrue($baseObject->size() == 1);
        $this->assertEquals("value1", $baseObject->get("key1.key2.key3"));
        
        $this->assertTrue($baseObject->containsKey("key1.key2.key4"));
        $this->assertEquals("value2", $baseObject->get("key1.key2.key4"));
        
        
        $this->assertFalse($baseObject->containsKey("key1.key2.key3."));
        $this->assertNull($baseObject->get("key1.key2.key3."));
        $this->assertFalse($baseObject->containsKey("key1.key2."));
        $this->assertNull($baseObject->get("key1.key2."));
        $this->assertFalse($baseObject->containsKey("key1."));
        $this->assertNull($baseObject->get("key1."));
        
        $this->assertFalse($baseObject->containsKey("key1.key2.something.different"));
        $this->assertNull($baseObject->get("key1.key2.something.different"));
        $this->assertFalse($baseObject->containsKey("key1.something.different"));
        $this->assertNull($baseObject->get("key1.something.different"));
        $this->assertFalse($baseObject->containsKey("key1..."));
        $this->assertNull($baseObject->get("key1..."));
                
        
    }
    
        public function testNestedMapWithList()
    {
        $body = "[ { \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" } ]";
        $baseMap = new BaseMap();
        $baseMap->setAll(json_decode($body, true));
        
        $this->assertEquals(1, $baseMap->size());
        $this->assertEquals("andrea", $baseMap->get("list[0].user.name"));
        $this->assertEquals("rizzini", $baseMap->get("list[0].user.surname"));
        
        
        $this->assertTrue($baseMap->containsKey("list"));
        $this->assertNotEmpty($baseMap->get("list"));
        $this->assertTrue($baseMap->containsKey("list[0]"));
        $this->assertNotEmpty($baseMap->get("list[0]"));
        $this->assertTrue($baseMap->containsKey("list[0].user"));
        $this->assertNotEmpty($baseMap->get("list[0].user"));
        $this->assertTrue($baseMap->containsKey("list[0].user.name"));
        $this->assertNotEmpty($baseMap->get("list[0].user.name"));
        $this->assertTrue($baseMap->containsKey("list[]"));
        $this->assertNotEmpty($baseMap->get("list[]"));
        $this->assertTrue($baseMap->containsKey("list[].user"));
        $this->assertNotEmpty($baseMap->get("list[].user"));
        $this->assertTrue($baseMap->containsKey("list[0].user.name"));
        $this->assertNotEmpty($baseMap->get("list[0].user.name"));
        
        $this->assertFalse($baseMap->containsKey("list2"));
        $this->assertEmpty($baseMap->get("list2"));
        $this->assertFalse($baseMap->containsKey("list[2]"));
        $this->assertEmpty($baseMap->get("list[2]"));
        
        $this->assertFalse($baseMap->containsKey("list[2].some.nonsense"));
        $this->assertEmpty($baseMap->get("list[2].some.nonsense"));
        $this->assertFalse($baseMap->containsKey("list[2].some...."));
        $this->assertEmpty($baseMap->get("list[2].some...."));
        
    }
    
    
    public function TestSetAll()
    {
        $map = array( "Account" => array( "Status" => true, "Listed" => true, "ReasonCode" => "S", "Reason" => "STOLEN"));
        $baseMap = new BaseMap();
        $baseMap->setAll($map);
        
        $this->assertTrue($baseMap != NULL);
        $this->assertTrue($baseMap->containsKey("Account.Status"));
        $this->assertTrue($baseMap->size() == 1);
        $this->assertEquals("STOLEN", $baseMap->get("Account.Reason"));
        
        
    }
    

    

            
}
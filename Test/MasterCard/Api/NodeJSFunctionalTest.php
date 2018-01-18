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

 use MasterCard\Core\Model\BaseObject;
 use MasterCard\Core\Model\RequestMap;
 use MasterCard\Core\ApiConfig;
 use MasterCard\Core\Security\OAuth\OAuthAuthentication;
 use MasterCard\Core\Exception\InvalidRequestException;


/**
 * 
 */
class NodeJSFunctionalTest extends BaseTest{
    
    
    public static function setUpBeforeClass() {
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        ApiConfig::setSandbox(true);
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
    }
    
    
    public function testActionReadFromPostWith200() {
        
        $readItem = Post::read("1");
        
        $this->assertNotNull($readItem);
        
        $this->assertEquals(1, $readItem->get("id"));
        $this->assertEquals("My Title", $readItem->get("title"));
        $this->assertEquals("some body text", $readItem->get("body"));
        $this->assertEquals(1, $readItem->get("userId"));
    }
    
    
    public function testActionReadFromPostWith500() {
        
        $this->expectException(\MasterCard\Core\Exception\ApiException::class);
        
        $readItem = Post::read("aaa");
        
    }
    
    
    
    public function testActionReadFromPostWithCriteria200() {
        
        $tmpArray = array(
            'one' => 1, 
            'two' => 2,
            'three' => 3, 
            'four' => 4
        );
                
        $readItem = Post::read("1", $tmpArray);
        
        $this->assertNotNull($readItem);
        
        $this->assertEquals(1, $readItem->get("id"));
        $this->assertEquals("My Title", $readItem->get("title"));
        $this->assertEquals("some body text", $readItem->get("body"));
        $this->assertEquals(1, $readItem->get("userId"));
    }

    
    public function testActionListFromPostWith200() {
        
                
        $createdItems = Post::listByCriteria();
        
        $this->assertInternalType('array', $createdItems);
              
        $createdItem = $createdItems[0];
        
        $this->assertEquals(1, $createdItem->get("id"));
        $this->assertEquals("My Title", $createdItem->get("title"));
        $this->assertEquals("some body text", $createdItem->get("body"));
        $this->assertEquals(1, $createdItem->get("userId"));
    }
    
    
    
    public function testActionListFromPostWithCriteria200() {
        
        $criteria = new RequestMap();
        $criteria->set("user_id", 5);
                
        $createdItems = Post::listByCriteria($criteria);
        
        $this->assertInternalType('array', $createdItems);
              
        $createdItem = $createdItems[0];
        
        $this->assertEquals(1, $createdItem->get("id"));
        $this->assertEquals("My Title", $createdItem->get("title"));
        $this->assertEquals("some body text", $createdItem->get("body"));
        $this->assertEquals(1, $createdItem->get("userId"));
    }
    
    
        
    
    
    public function testActionCreateFromPostWith200() {
        
        $requestMap = new RequestMap();
        $requestMap->set("id", 1)->set("title", "My Title")->set("body", "some long text");
        
        $createdItem = Post::create($requestMap);
        
        $this->assertNotNull($createdItem);
        
        
        $this->assertEquals(1, $createdItem->get("id"));
        $this->assertEquals("My Title", $createdItem->get("title"));
        $this->assertEquals("some body text", $createdItem->get("body"));
        $this->assertEquals(1, $createdItem->get("userId"));
    }
    
    
    public function testActionUpdateFromPost200() {
        
        $requestMap = new RequestMap();
        $requestMap->set("id", 1)->set("title", "My Title")->set("body", "some long text");
        
        $createdItem = Post::create($requestMap);
        $this->assertNotNull($createdItem);
        
        $createdItem->set("body", "updated body");
        $createdItem->set("title", "updated title");
        
        $updatedItem = $createdItem->update();
        
        
        $this->assertEquals(1, $updatedItem->get("id"));
        $this->assertEquals("updated title", $updatedItem->get("title"));
        $this->assertEquals("updated body", $updatedItem->get("body"));
        $this->assertEquals(1, $updatedItem->get("userId"));
    }
    
    public function testActionDeleteFromPost200() {
        
        $deletedItem = Post::deleteById("1");
        
        $this->assertEquals(0, $deletedItem->size());
               
        
    }
    
    public function testActionListFromUserPostPath200() {
        $requestMap = new RequestMap();
        $requestMap->set("user_id", 1);
        
        $items =UserPostPath::listByCriteria($requestMap);
        
        $this->assertInternalType('array', $items);
              
        $item = $items[0];
        
        $this->assertEquals(1, $item->get("id"));
        $this->assertEquals("My Title", $item->get("title"));
        $this->assertEquals("some body text", $item->get("body"));
        $this->assertEquals(1, $item->get("userId"));
    }
    
    public function testActionListFromUserHeaderPath200() {
        $requestMap = new RequestMap();
        $requestMap->set("user_id", 1);
        
        $items =  UserPostHeader::listByCriteria($requestMap);
        
        $this->assertInternalType('array', $items);
              
        $item = $items[0];
        
        $this->assertEquals(1, $item->get("id"));
        $this->assertEquals("My Title", $item->get("title"));
        $this->assertEquals("some body text", $item->get("body"));
        $this->assertEquals(1, $item->get("userId"));
    }
    
    
    public function testActionMultipathDelete200() {
        $requestMap = new RequestMap();
        $requestMap->set("user_id", 1);
        $requestMap->set("post_id", 1);
        

        
        $deletedItem = MultiplePathUserPost::deleteById(null, $requestMap);
        $this->assertEquals(0, $deletedItem->size());
        
        $requestArray = array(
            'user_id' => 1, 
            'post_id' => 1,
        );
        
        $deletedItem = MultiplePathUserPost::deleteById(null, $requestArray);      
        $this->assertEquals(0, $deletedItem->size());
    }

}


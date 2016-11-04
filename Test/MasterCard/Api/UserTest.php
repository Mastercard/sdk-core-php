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

use MasterCard\Core\Model\RequestMap;
use MasterCard\Core\ApiConfig;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;



class UserTest extends BaseTest {

    public static $responses = array();

    protected function setUp() {
        parent::setUp();
        ApiConfig::setDebug(false);
        ApiConfig::setSandbox(true);
    }

    
    
    
    
                
        public function test_list_users()
        {
            

            

            $map = new RequestMap();
            
            
            $responseList = User::listByCriteria($map);

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $responseList[0], "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "id", "1");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "username", "jbloggs");
            

            self::putResponse("list_users", $responseList[0]);
            
        }
        
        public function test_list_users_query()
        {
            

            

            $map = new RequestMap();
            $map->set("max", "10");
            
            
            $responseList = User::listByCriteria($map);

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $responseList[0], "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "id", "1");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "username", "jbloggs");
            

            self::putResponse("list_users_query", $responseList[0]);
            
        }
        
    
    
    
    
    
    
                
        public function test_create_user()
        {
            

            

            $map = new RequestMap();
            $map->set("website", "hildegard.org");
            $map->set("address.city", "New York");
            $map->set("address.postalCode", "10577");
            $map->set("address.state", "NY");
            $map->set("address.line1", "2000 Purchase Street");
            $map->set("phone", "1-770-736-8031");
            $map->set("name", "Joe Bloggs");
            $map->set("email", "name@example.com");
            $map->set("username", "jbloggs");
            
            
            $response = User::create($map);

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $response, "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $response, "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $response, "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $response, "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $response, "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $response, "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $response, "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $response, "id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $response, "username", "jbloggs");
            

            self::putResponse("create_user", $response);
            
        }
        
    
    
    
    
    
    
    
    
    
    
    
    
                

        public function test_get_user()
        {
            

            

            $id = "";

            $map = new RequestMap();
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            

            $response = User::read($id,$map);

            $ignoreAssert = array();
            $ignoreAssert[] = "address.city";
            
            $this->customAssertEqual($ignoreAssert, $response, "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $response, "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $response, "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $response, "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $response, "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $response, "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $response, "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $response, "id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $response, "username", "jbloggs");
            

            self::putResponse("get_user", $response);
            
        }
        

        public function test_get_user_query()
        {
            

            

            $id = "";

            $map = new RequestMap();
            $map->set("min", "1");
            $map->set("max", "10");
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            

            $response = User::read($id,$map);

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $response, "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $response, "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $response, "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $response, "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $response, "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $response, "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $response, "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $response, "id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $response, "username", "jbloggs");
            

            self::putResponse("get_user_query", $response);
            
        }
        
    
    
    
    
    
                

        public function test_update_user()
        {
            

            

            $map = new RequestMap();
            $map->set ("name", "Joe Bloggs");
            $map->set ("username", "jbloggs");
            $map->set ("email", "name@example.com");
            $map->set ("phone", "1-770-736-8031");
            $map->set ("website", "hildegard.org");
            $map->set ("address.line1", "2000 Purchase Street");
            $map->set ("address.city", "New York");
            $map->set ("address.state", "NY");
            $map->set ("address.postalCode", "10577");
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            $map->set("id2", self::resolveResponseValue("create_user.id"));
            $map->set("prepend", "prepend".self::resolveResponseValue("create_user.id"));
            $map->set("append", self::resolveResponseValue("create_user.id")."append");
            $map->set("complex", "prepend-".self::resolveResponseValue("create_user.id")."-".self::resolveResponseValue("create_user.name"));
            $map->set("name", self::resolveResponseValue("val:Andrea Rizzini"));
            
            $request = new User($map);
            $response = $request->update();

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $response, "website", "hildegard.org");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.doorman", "true");
            $this->customAssertEqual($ignoreAssert, $response, "address.instructions.text", "some delivery instructions text");
            $this->customAssertEqual($ignoreAssert, $response, "address.city", "New York");
            $this->customAssertEqual($ignoreAssert, $response, "address.postalCode", "10577");
            $this->customAssertEqual($ignoreAssert, $response, "address.id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "address.state", "NY");
            $this->customAssertEqual($ignoreAssert, $response, "address.line1", "2000 Purchase Street");
            $this->customAssertEqual($ignoreAssert, $response, "phone", "1-770-736-8031");
            $this->customAssertEqual($ignoreAssert, $response, "name", "Joe Bloggs");
            $this->customAssertEqual($ignoreAssert, $response, "id", "1");
            $this->customAssertEqual($ignoreAssert, $response, "email", "name@example.com");
            $this->customAssertEqual($ignoreAssert, $response, "username", "jbloggs");
            

            self::putResponse("update_user", $response);
            
        }
        
    
    
    
    
    
    
    
    
    
    
                

        public function test_delete_user()
        {
            

            

            $map = new RequestMap();
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            
            $response = User::deleteById("ssss", $map);
            $this->assertNotNull($response);

            $ignoreAssert = array();
            
            

            self::putResponse("delete_user", $response);
            
        }
        

    
    
    
    
    
    
    
    
                

        public function test_delete_user_200()
        {
            

            

            $map = new RequestMap();
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            
            $response = User::delete200ById("ssss", $map);
            $this->assertNotNull($response);

            $ignoreAssert = array();
            
            

            self::putResponse("delete_user_200", $response);
            
        }
        

    
    
    
    
    
    
    
    
                

        public function test_delete_user_204()
        {
            

            

            $map = new RequestMap();
            
            $map->set("id", self::resolveResponseValue("create_user.id"));
            
            $response = User::delete204ById("ssss", $map);
            $this->assertNotNull($response);

            $ignoreAssert = array();
            
            

            self::putResponse("delete_user_204", $response);
            
        }
        

    
    
    
    
}




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



class MultiplePathUserPostTest extends BaseTest {

    public static $responses = array();

    protected function setUp() {
        parent::setUp();
        ApiConfig::setDebug(false);
        ApiConfig::setSandbox(true);
    }

    
    
    
    
                
        public function test_get_user_posts_with_mutplie_path()
        {
            

            

            $map = new RequestMap();
            $map->set("user_id", "1");
            $map->set("post_id", "2");
            
            
            $responseList = MultiplePathUserPost::listByCriteria($map);

            $ignoreAssert = array();
            
            $this->customAssertEqual($ignoreAssert, $responseList[0], "id", "1");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "title", "My Title");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "body", "some body text");
            $this->customAssertEqual($ignoreAssert, $responseList[0], "userId", "1");
            

            self::putResponse("get_user_posts_with_mutplie_path", $responseList[0]);
            
        }
        
    
    
    
    
    
    
    
                

        public function test_update_user_posts_with_mutplie_path()
        {
            

            

            $map = new RequestMap();
            $map->set ("user_id", "1");
            $map->set ("post_id", "1");
            $map->set ("testQuery", "testQuery");
            $map->set ("name", "Joe Bloggs");
            $map->set ("username", "jbloggs");
            $map->set ("email", "name@example.com");
            $map->set ("phone", "1-770-736-8031");
            $map->set ("website", "hildegard.org");
            $map->set ("address.line1", "2000 Purchase Street");
            $map->set ("address.city", "New York");
            $map->set ("address.state", "NY");
            $map->set ("address.postalCode", "10577");
            
            
            $request = new MultiplePathUserPost($map);
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
            

            self::putResponse("update_user_posts_with_mutplie_path", $response);
            
        }
        
    
    
    
    
    
    
    
    
    
    
                

        public function test_delete_user_posts_with_mutplie_path()
        {
            

            

            $map = new RequestMap();
            $map->set("user_id", "1");
            $map->set("post_id", "2");
            
            
            $response = MultiplePathUserPost::deleteById("", $map);
            $this->assertNotNull($response);

            $ignoreAssert = array();
            
            

            self::putResponse("delete_user_posts_with_mutplie_path", $response);
            
        }
        

    
    
    
    
}




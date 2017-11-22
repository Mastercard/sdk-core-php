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


class AccountInquiryTest extends BaseTest {

    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
        ApiConfig::setDebug(false);
    }
    
    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        ApiConfig::setProxy(null);
    }




    // public function test_example_stolen_with_proxy()
    // {
    //     //example_stolen
    //     $map = new RequestMap();
    //     $map->set ("AccountInquiry.AccountNumber", "5343434343434343");
    //     ApiConfig::setProxy(['http'  => 'http://localhost:9999', 'https' => 'http://localhost:9999']);

    //     $request = new AccountInquiry($map);
    //     $response = $request->update();
    //     $this->assertEquals(strtolower("True"), strtolower(str_replace("'", "", var_export($response->get("Account.Listed"), true))));
    //     $this->assertEquals(strtolower("S"), strtolower($response->get("Account.ReasonCode")));
    //     $this->assertEquals(strtolower("STOLEN"), strtolower($response->get("Account.Reason")));

    // }
        





    public function test_example_stolen()
    {
        //example_stolen
        $map = new RequestMap();
        $map->set ("AccountInquiry.AccountNumber", "5343434343434343");

        $request = new AccountInquiry($map);
        $response = $request->update();
        $this->assertEquals(strtolower("True"), strtolower(str_replace("'", "", var_export($response->get("Account.Listed"), true))));
        $this->assertEquals(strtolower("S"), strtolower($response->get("Account.ReasonCode")));
        $this->assertEquals(strtolower("STOLEN"), strtolower($response->get("Account.Reason")));

    }
        

    public function test_example_lost()
    {
        //example_lost
        $map = new RequestMap();
        $map->set ("AccountInquiry.AccountNumber", "5222222222222200");

        $request = new AccountInquiry($map);
        $response = $request->update();
        $this->assertEquals(strtolower("True"), strtolower(str_replace("'", "", var_export($response->get("Account.Listed"), true))));
        $this->assertEquals(strtolower("L"), strtolower($response->get("Account.ReasonCode")));
        $this->assertEquals(strtolower("LOST"), strtolower($response->get("Account.Reason")));

    }

    
    
    
    
    

}


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



class ParametersTest extends BaseTest{

    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
    }
    
    
    
    
                

        public function test_example_parameters()
        {

            $this->markTestSkipped('sandbox is down.');
            
            $map = new RequestMap();
            
            $map->set("CurrentRow", "1");
            $map->set("Offset", "25");
            
            

            $response = Parameters::query($map);
            $this->assertEquals(strtolower("NO"), strtolower($response->get("ParameterList.ParameterArray.Parameter[1].Ecomm")));
            $this->assertEquals(strtolower("Quarterly"), strtolower($response->get("ParameterList.ParameterArray.Parameter[1].Period")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("ParameterList.ParameterArray.Parameter[2].Ecomm")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("ParameterList.ParameterArray.Parameter[0].Ecomm")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("ParameterList.ParameterArray.Parameter[0].Sector")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("ParameterList.ParameterArray.Parameter[1].Sector")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("ParameterList.ParameterArray.Parameter[2].Sector")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("ParameterList.ParameterArray.Parameter[0].Period")));
            $this->assertEquals(strtolower("Success"), strtolower($response->get("ParameterList.Message")));
            $this->assertEquals(strtolower("3"), strtolower($response->get("ParameterList.Count")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("ParameterList.ParameterArray.Parameter[0].Country")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("ParameterList.ParameterArray.Parameter[2].Period")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("ParameterList.ParameterArray.Parameter[1].Country")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("ParameterList.ParameterArray.Parameter[2].Country")));
            

        }
        
    
    
}




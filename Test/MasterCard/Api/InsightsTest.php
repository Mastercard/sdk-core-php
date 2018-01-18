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
use Monolog\Logger;
use Monolog\Handler\StreamHandler;



class InsightsTest extends BaseTest {
    
    protected function setUp() {
        parent::setUp();
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
    }
    
    

//    public function test_example_insights()
//    {
//
//        $map = new RequestMap();
//
//        $map->set("CurrentRow", "1");
//        $map->set("Offset", "25");
//        $map->set("Country", "US");
//
//
//
//        $response = Insights::query($map);
//        $this->assertEquals(str_replace("'", "", strtolower("70")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.Count"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("Success")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.Message"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("US")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Country"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("U.S. Natural and Organic Grocery Stores")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Sector"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("NO")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Ecomm"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("Monthly")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Period"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("11/30/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].BeginDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("1/3/2015")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].EndDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("0.049201983")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].SalesIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("-0.029602284")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].AverageTicketIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("7146577.851")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].SalesIndexValue"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("US")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Country"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("U.S. Natural and Organic Grocery Stores")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Sector"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("NO")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Ecomm"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("Monthly")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Period"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("11/2/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].BeginDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("11/29/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].EndDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("0.074896863")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].SalesIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("-0.007884916")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].AverageTicketIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("5390273.888")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].SalesIndexValue"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("US")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Country"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("U.S. Natural and Organic Grocery Stores")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Sector"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("NO")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Ecomm"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("Monthly")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Period"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("10/5/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].BeginDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("11/1/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].EndDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("0.077937282")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].SalesIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("-0.010073866")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].AverageTicketIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("4776139.381")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].SalesIndexValue"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("US")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Country"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("U.S. Natural and Organic Grocery Stores")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Sector"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("NO")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Ecomm"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("Monthly")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Period"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("9/7/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].BeginDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("10/4/2014")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].EndDate"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("0.089992028")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].SalesIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("-0.00577838")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].AverageTicketIndex"), true))));
//        $this->assertEquals(str_replace("'", "", strtolower("4716899.304")), strtolower(str_replace("'", "", var_export($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].SalesIndexValue"), true))));
//
//
//    }
        
        
            
    
       
    
    
}




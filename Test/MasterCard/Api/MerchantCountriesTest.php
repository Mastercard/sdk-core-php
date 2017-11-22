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
use MasterCard\Api\MerchantCategories;



class MerchantCountriesTest extends BaseTest {

    protected function setUp() {
        ApiConfig::setDebug(false);
        ApiConfig::setSandbox(true);
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
    }
    
    
    
    
    
    
    
                

        public function test_example_merchants_country()
        {

            $this->markTestSkipped('sandbox is down.');
            
            $map = new RequestMap();
            
            $map->set("details", "acceptance.paypass");
            
            

            $response = MerchantCountries::query($map);
            $this->assertEquals(str_replace("'", "", strtolower("AUSTRALIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[0].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("AUS")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[0].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[0].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("AUSTRIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[1].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("AUT")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[1].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[1].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("BELGIUM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[2].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("BEL")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[2].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[2].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("BERMUDA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[3].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("BMU")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[3].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[3].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CANADA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[4].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CAN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[4].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[4].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("COLOMBIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[5].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("COL")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[5].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[5].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CROATIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[6].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("HRV")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[6].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[6].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CZECH REPUBLIC")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[7].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CZE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[7].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[7].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("DENMARK")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[8].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("DNK")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[8].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[8].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FINLAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[9].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FIN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[9].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[9].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FRANCE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[10].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FRA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[10].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[10].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GERMANY")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[11].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("DEU")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[11].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[11].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GREECE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[12].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GRC")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[12].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[12].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GUAM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[13].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GUM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[13].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[13].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("HUNGARY")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[14].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("HUN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[14].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[14].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ICELAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[15].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ISL")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[15].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[15].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ITALY")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[16].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ITA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[16].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[16].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("JAPAN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[17].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("JPN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[17].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[17].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("KAZAKHSTAN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[18].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("KAZ")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[18].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[18].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("LEBANON")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[19].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("LBN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[19].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[19].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MACEDONIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[20].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MKD")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[20].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[20].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MEXICO")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[21].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MEX")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[21].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[21].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MONACO")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[22].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MCO")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[22].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[22].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MONTENEGRO")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[23].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("MNE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[23].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[23].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NETHERLANDS")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[24].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NLD")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[24].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[24].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NEW ZEALAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[25].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NZL")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[25].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[25].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NORWAY")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[26].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("NOR")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[26].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[26].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("POLAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[27].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("POL")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[27].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[27].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("PUERTO RICO")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[28].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("PRI")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[28].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[28].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ROMANIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[29].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ROM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[29].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[29].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SERBIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[30].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SRB")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[30].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[30].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SINGAPORE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[31].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SGP")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[31].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[31].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SLOVAKIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[32].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SVK")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[32].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[32].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SLOVENIA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[33].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SVN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[33].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[33].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SPAIN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[34].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("ESP")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[34].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[34].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SWEDEN")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[35].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SWE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[35].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[35].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("SWITZERLAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[36].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("CHE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[36].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[36].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("THAILAND")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[37].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("THA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[37].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[37].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TURKEY")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[38].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TUR")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[38].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[38].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("UNITED KINGDOM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[39].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("GBR")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[39].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[39].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("UNITED STATES")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[40].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("USA")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[40].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("TRUE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[40].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("VIET NAM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[41].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("VNM")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[41].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[41].Geocoding"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("VIRGIN ISLANDS U.S.")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[42].Name"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("VIR")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[42].Code"), true))));
            $this->assertEquals(str_replace("'", "", strtolower("FALSE")), strtolower(str_replace("'", "", var_export($response->get("Countries.Country[42].Geocoding"), true))));
            

        }
        
    
    
}




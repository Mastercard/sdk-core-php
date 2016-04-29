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

use MasterCard\Core\Model\BaseMap;
use MasterCard\Core\ApiConfig;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;



class InsightsTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/prod_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $privateKey, "alias", "password"));
    }
    
    
    
    
    
    
    
                

        public function test_example_insights()
        {

            $map = new BaseMap();
            
            $map->set("Period", "");
            $map->set("CurrentRow", "1");
            $map->set("Sector", "");
            $map->set("Offset", "25");
            $map->set("Country", "US");
            $map->set("Ecomm", "");
            
            

            $response = Insights::query($map);
            $this->assertEquals(strtolower("11/30/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.033862493"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].SalesIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].Sector")));
            $this->assertEquals(strtolower("11/9/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].YearBeforeEndDate")));
            $this->assertEquals(strtolower("11/30/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.083439694"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].TransactionsIndex")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Period")));
            $this->assertEquals(strtolower("0.064810496"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].TransactionsIndex")));
            $this->assertEquals(strtolower("11/2/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].BeginDate")));
            $this->assertEquals(strtolower("7/13/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].YearBeforeEndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].Ecomm")));
            $this->assertEquals(strtolower("8/10/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].BeginDate")));
            $this->assertEquals(strtolower("12/27/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].EndDate")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].Period")));
            $this->assertEquals(strtolower("12/30/2012"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("4666390.074"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].SalesIndexValue")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].Country")));
            $this->assertEquals(strtolower("11/2/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].BeginDate")));
            $this->assertEquals(strtolower("-0.003968331"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].AverageTicketIndex")));
            $this->assertEquals(strtolower("14586848.49"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].SalesIndexValue")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].Sector")));
            $this->assertEquals(strtolower("0.089399728"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].TransactionsIndex")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].Period")));
            $this->assertEquals(strtolower("0.070222262"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].SalesIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].Country")));
            $this->assertEquals(strtolower("4610930.63"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].SalesIndexValue")));
            $this->assertEquals(strtolower("3/23/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].BeginDate")));
            $this->assertEquals(strtolower("-0.00577838"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].AverageTicketIndex")));
            $this->assertEquals(strtolower("12/7/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].YearBeforeEndDate")));
            $this->assertEquals(strtolower("Success"), strtolower($response->get("SectorRecordList.Message")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].Ecomm")));
            $this->assertEquals(strtolower("11/3/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.011748007"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].SalesIndex")));
            $this->assertEquals(strtolower("4895914.274"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].SalesIndexValue")));
            $this->assertEquals(strtolower("12/14/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].BeginDate")));
            $this->assertEquals(strtolower("12/8/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.089992028"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].SalesIndex")));
            $this->assertEquals(strtolower("0.083737514"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].SalesIndex")));
            $this->assertEquals(strtolower("11/1/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].EndDate")));
            $this->assertEquals(strtolower("4463445.742"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].SalesIndexValue")));
            $this->assertEquals(strtolower("0.035568928"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].SalesIndex")));
            $this->assertEquals(strtolower("Quarterly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].Period")));
            $this->assertEquals(strtolower("-0.000125706"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].AverageTicketIndex")));
            $this->assertEquals(strtolower("11/17/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("2/24/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("12/13/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].EndDate")));
            $this->assertEquals(strtolower("0.000253361"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].AverageTicketIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].Sector")));
            $this->assertEquals(strtolower("0.095643662"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].TransactionsIndex")));
            $this->assertEquals(strtolower("12/28/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].BeginDate")));
            $this->assertEquals(strtolower("1/26/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].YearBeforeEndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].Ecomm")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].Period")));
            $this->assertEquals(strtolower("0.077937282"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].SalesIndex")));
            $this->assertEquals(strtolower("9/7/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].BeginDate")));
            $this->assertEquals(strtolower("0.004143999"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].AverageTicketIndex")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].Ecomm")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].Country")));
            $this->assertEquals(strtolower("13956974.12"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].SalesIndexValue")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].Sector")));
            $this->assertEquals(strtolower("0.086861262"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].TransactionsIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].Country")));
            $this->assertEquals(strtolower("1/27/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.102417809"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].TransactionsIndex")));
            $this->assertEquals(strtolower("5390273.888"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].SalesIndexValue")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].Country")));
            $this->assertEquals(strtolower("0.080227189"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].SalesIndex")));
            $this->assertEquals(strtolower("5/18/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].BeginDate")));
            $this->assertEquals(strtolower("11/30/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].BeginDate")));
            $this->assertEquals(strtolower("10/5/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].BeginDate")));
            $this->assertEquals(strtolower("0.117574514"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].SalesIndex")));
            $this->assertEquals(strtolower("11/29/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].EndDate")));
            $this->assertEquals(strtolower("11/22/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].EndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].Ecomm")));
            $this->assertEquals(strtolower("0.046899887"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].TransactionsIndex")));
            $this->assertEquals(strtolower("1/3/2015"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].EndDate")));
            $this->assertEquals(strtolower("0.049201983"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].SalesIndex")));
            $this->assertEquals(strtolower("Quarterly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].Period")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].Ecomm")));
            $this->assertEquals(strtolower("11/24/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.010714415"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].SalesIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].Sector")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].Period")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].Period")));
            $this->assertEquals(strtolower("22029890.42"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].SalesIndexValue")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Country")));
            $this->assertEquals(strtolower("6/15/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].BeginDate")));
            $this->assertEquals(strtolower("-0.001106025"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].AverageTicketIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].Sector")));
            $this->assertEquals(strtolower("4/20/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].YearBeforeEndDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].Country")));
            $this->assertEquals(strtolower("11/2/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.034610621"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].TransactionsIndex")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].Period")));
            $this->assertEquals(strtolower("11/16/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].YearBeforeEndDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].Country")));
            $this->assertEquals(strtolower("0.081004826"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].TransactionsIndex")));
            $this->assertEquals(strtolower("12/29/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].BeginDate")));
            $this->assertEquals(strtolower("0.050445564"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].TransactionsIndex")));
            $this->assertEquals(strtolower("1332036.912"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].SalesIndexValue")));
            $this->assertEquals(strtolower("12/29/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].Country")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].Sector")));
            $this->assertEquals(strtolower("12/22/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].Country")));
            $this->assertEquals(strtolower("0.081037693"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].SalesIndex")));
            $this->assertEquals(strtolower("Quarterly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].Period")));
            $this->assertEquals(strtolower("3/23/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].BeginDate")));
            $this->assertEquals(strtolower("0.088906782"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].TransactionsIndex")));
            $this->assertEquals(strtolower("9/6/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].EndDate")));
            $this->assertEquals(strtolower("9/7/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].YearBeforeEndDate")));
            $this->assertEquals(strtolower("11/29/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].EndDate")));
            $this->assertEquals(strtolower("1/26/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].BeginDate")));
            $this->assertEquals(strtolower("11/9/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].BeginDate")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].Period")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].Ecomm")));
            $this->assertEquals(strtolower("1350468.126"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].SalesIndexValue")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Ecomm")));
            $this->assertEquals(strtolower("0.06399651"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].SalesIndex")));
            $this->assertEquals(strtolower("4716264.801"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].SalesIndexValue")));
            $this->assertEquals(strtolower("4776139.381"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].SalesIndexValue")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].Ecomm")));
            $this->assertEquals(strtolower("1789039.367"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].SalesIndexValue")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].Country")));
            $this->assertEquals(strtolower("-0.009346738"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].AverageTicketIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Sector")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].Country")));
            $this->assertEquals(strtolower("0.076812652"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].SalesIndex")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].Ecomm")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Sector")));
            $this->assertEquals(strtolower("1/4/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.077862316"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].SalesIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Sector")));
            $this->assertEquals(strtolower("0.096327022"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].TransactionsIndex")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].Ecomm")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].Ecomm")));
            $this->assertEquals(strtolower("11/16/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].BeginDate")));
            $this->assertEquals(strtolower("-0.000775331"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].AverageTicketIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].Sector")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].Sector")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].Sector")));
            $this->assertEquals(strtolower("13768292.67"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].SalesIndexValue")));
            $this->assertEquals(strtolower("-0.009014519"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].AverageTicketIndex")));
            $this->assertEquals(strtolower("3/22/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].EndDate")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].Period")));
            $this->assertEquals(strtolower("0.064357166"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].SalesIndex")));
            $this->assertEquals(strtolower("6/16/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.026920473"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].TransactionsIndex")));
            $this->assertEquals(strtolower("-0.010073866"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].AverageTicketIndex")));
            $this->assertEquals(strtolower("-0.000552344"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].AverageTicketIndex")));
            $this->assertEquals(strtolower("9/7/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].BeginDate")));
            $this->assertEquals(strtolower("10/5/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].YearBeforeEndDate")));
            $this->assertEquals(strtolower("11/23/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].BeginDate")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].Sector")));
            $this->assertEquals(strtolower("1185950.237"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].SalesIndexValue")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].Ecomm")));
            $this->assertEquals(strtolower("12/21/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].BeginDate")));
            $this->assertEquals(strtolower("0.077620825"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].TransactionsIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].Sector")));
            $this->assertEquals(strtolower("4574319.24"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].SalesIndexValue")));
            $this->assertEquals(strtolower("6/14/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].EndDate")));
            $this->assertEquals(strtolower("3/24/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].Sector")));
            $this->assertEquals(strtolower("-0.022654487"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].AverageTicketIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].Sector")));
            $this->assertEquals(strtolower("1193299.96"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].SalesIndexValue")));
            $this->assertEquals(strtolower("12/28/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.099764512"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].SalesIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Country")));
            $this->assertEquals(strtolower("-0.0498328"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].AverageTicketIndex")));
            $this->assertEquals(strtolower("0.026791383"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].SalesIndex")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].Period")));
            $this->assertEquals(strtolower("2/23/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.13335406"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].SalesIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].Sector")));
            $this->assertEquals(strtolower("8/11/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("1/4/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].YearBeforeEndDate")));
            $this->assertEquals(strtolower("6/14/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].EndDate")));
            $this->assertEquals(strtolower("11/3/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("11/15/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].EndDate")));
            $this->assertEquals(strtolower("12/30/2012"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Period")));
            $this->assertEquals(strtolower("1244980.145"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].SalesIndexValue")));
            $this->assertEquals(strtolower("4938904.288"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].SalesIndexValue")));
            $this->assertEquals(strtolower("0.094649123"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].TransactionsIndex")));
            $this->assertEquals(strtolower("12/15/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].Period")));
            $this->assertEquals(strtolower("4/19/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].EndDate")));
            $this->assertEquals(strtolower("0.081208216"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].TransactionsIndex")));
            $this->assertEquals(strtolower("11/10/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("9/8/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].Ecomm")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].Ecomm")));
            $this->assertEquals(strtolower("-0.007884916"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].AverageTicketIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].Country")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].Period")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].Ecomm")));
            $this->assertEquals(strtolower("0.074896863"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].SalesIndex")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].Period")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].Ecomm")));
            $this->assertEquals(strtolower("-0.010866807"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].AverageTicketIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].Country")));
            $this->assertEquals(strtolower("4716899.304"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].SalesIndexValue")));
            $this->assertEquals(strtolower("5/18/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].YearBeforeEndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].Ecomm")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].Ecomm")));
            $this->assertEquals(strtolower("7/12/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].EndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].Ecomm")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Country")));
            $this->assertEquals(strtolower("70"), strtolower($response->get("SectorRecordList.Count")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].Ecomm")));
            $this->assertEquals(strtolower("0.093480745"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].SalesIndex")));
            $this->assertEquals(strtolower("9/7/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].YearBeforeEndDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Period")));
            $this->assertEquals(strtolower("-0.008106785"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].AverageTicketIndex")));
            $this->assertEquals(strtolower("4693916.302"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].SalesIndexValue")));
            $this->assertEquals(strtolower("1/3/2015"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].EndDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].Country")));
            $this->assertEquals(strtolower("0.091237201"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[24].TransactionsIndex")));
            $this->assertEquals(strtolower("8/10/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.134608966"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].TransactionsIndex")));
            $this->assertEquals(strtolower("-0.015309221"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].AverageTicketIndex")));
            $this->assertEquals(strtolower("Weekly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].Period")));
            $this->assertEquals(strtolower("0.022281044"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].SalesIndex")));
            $this->assertEquals(strtolower("11/23/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].YearBeforeEndDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].Period")));
            $this->assertEquals(strtolower("11/30/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].BeginDate")));
            $this->assertEquals(strtolower("0.100372296"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].TransactionsIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].Country")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].Country")));
            $this->assertEquals(strtolower("10/6/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("12/6/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].EndDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[2].Country")));
            $this->assertEquals(strtolower("2/22/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].EndDate")));
            $this->assertEquals(strtolower("-0.029602284"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].AverageTicketIndex")));
            $this->assertEquals(strtolower("1601525.658"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].SalesIndexValue")));
            $this->assertEquals(strtolower("-0.011554139"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].AverageTicketIndex")));
            $this->assertEquals(strtolower("0.035983443"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].TransactionsIndex")));
            $this->assertEquals(strtolower("1/3/2015"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].EndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].Ecomm")));
            $this->assertEquals(strtolower("-0.012642959"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].AverageTicketIndex")));
            $this->assertEquals(strtolower("9/8/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].Sector")));
            $this->assertEquals(strtolower("6/15/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].YearBeforeEndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].Ecomm")));
            $this->assertEquals(strtolower("3/23/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].YearBeforeEndDate")));
            $this->assertEquals(strtolower("7/14/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("0.005715632"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].AverageTicketIndex")));
            $this->assertEquals(strtolower("8/9/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].EndDate")));
            $this->assertEquals(strtolower("7146577.851"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].SalesIndexValue")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Ecomm")));
            $this->assertEquals(strtolower("9/6/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].EndDate")));
            $this->assertEquals(strtolower("11/8/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].EndDate")));
            $this->assertEquals(strtolower("-0.03782314"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].AverageTicketIndex")));
            $this->assertEquals(strtolower("-0.042517568"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].AverageTicketIndex")));
            $this->assertEquals(strtolower("12/1/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].Country")));
            $this->assertEquals(strtolower("0.097922083"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].TransactionsIndex")));
            $this->assertEquals(strtolower("0.059573011"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[21].TransactionsIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].Sector")));
            $this->assertEquals(strtolower("3/24/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("1/25/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].EndDate")));
            $this->assertEquals(strtolower("12/14/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].YearBeforeEndDate")));
            $this->assertEquals(strtolower("12/29/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].BeginDate")));
            $this->assertEquals(strtolower("6/16/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Ecomm")));
            $this->assertEquals(strtolower("0.074039112"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].TransactionsIndex")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].Sector")));
            $this->assertEquals(strtolower("-0.002047282"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].AverageTicketIndex")));
            $this->assertEquals(strtolower("0.1129624"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].TransactionsIndex")));
            $this->assertEquals(strtolower("1518287.003"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].SalesIndexValue")));
            $this->assertEquals(strtolower("4/20/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].BeginDate")));
            $this->assertEquals(strtolower("0.048107305"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].SalesIndex")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].Period")));
            $this->assertEquals(strtolower("12/7/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].BeginDate")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[17].Sector")));
            $this->assertEquals(strtolower("0.052883582"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].SalesIndex")));
            $this->assertEquals(strtolower("6/15/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].YearBeforeEndDate")));
            $this->assertEquals(strtolower("12/1/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[9].Period")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[13].Sector")));
            $this->assertEquals(strtolower("1/4/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[0].YearBeforeEndDate")));
            $this->assertEquals(strtolower("0.098200253"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].SalesIndex")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[25].Country")));
            $this->assertEquals(strtolower("7/13/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].BeginDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[11].Period")));
            $this->assertEquals(strtolower("4/21/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("-0.011917118"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].AverageTicketIndex")));
            $this->assertEquals(strtolower("5/17/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[8].EndDate")));
            $this->assertEquals(strtolower("1321264.332"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].SalesIndexValue")));
            $this->assertEquals(strtolower("10/4/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[3].EndDate")));
            $this->assertEquals(strtolower("6/15/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].BeginDate")));
            $this->assertEquals(strtolower("0.127285919"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].SalesIndex")));
            $this->assertEquals(strtolower("5/19/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].YearBeforeBeginDate")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[20].Country")));
            $this->assertEquals(strtolower("0.131777185"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[18].TransactionsIndex")));
            $this->assertEquals(strtolower("-0.002907027"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[4].AverageTicketIndex")));
            $this->assertEquals(strtolower("Quarterly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[14].Period")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].Sector")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[1].Sector")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[7].Period")));
            $this->assertEquals(strtolower("4752029.923"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[5].SalesIndexValue")));
            $this->assertEquals(strtolower("0.081065373"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].TransactionsIndex")));
            $this->assertEquals(strtolower("12/21/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].YearBeforeEndDate")));
            $this->assertEquals(strtolower("3/22/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].EndDate")));
            $this->assertEquals(strtolower("NO"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].Ecomm")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[15].Country")));
            $this->assertEquals(strtolower("U.S. Natural and Organic Grocery Stores"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[6].Sector")));
            $this->assertEquals(strtolower("3/23/2013"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[16].YearBeforeEndDate")));
            $this->assertEquals(strtolower("2/23/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[10].BeginDate")));
            $this->assertEquals(strtolower("Monthly"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[12].Period")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[23].Country")));
            $this->assertEquals(strtolower("US"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[22].Country")));
            $this->assertEquals(strtolower("12/20/2014"), strtolower($response->get("SectorRecordList.SectorRecordArray.SectorRecord[19].EndDate")));
            

        }
        
    
    
}




<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MasterCard\Api;

use MasterCard\Core\Model\BaseMap;
use MasterCard\Core\ApiConfig;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;

class AccountEnquiryTest extends \PHPUnit_Framework_TestCase {
    
    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/prod_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $privateKey, "alias", "password"));
    }
    
    public function test_example_stolen() {
        
        $baseMap = new BaseMap();
        $baseMap->set("AccountInquiry.AccountNumber", "5343434343434343");
        
        $accountEnquiry = new AccountEnquiry($baseMap);
        $response = $accountEnquiry->update();
        
        
        $this->assertEquals("true", $response->get("Account.Status"));
        $this->assertEquals("STOLEN", $response->get("Account.Reason"));
        $this->assertEquals("S", $response->get("Account.ReasonCode"));
        
        
    }
    
}
    
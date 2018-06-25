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

namespace MasterCard\Core\Security\OAuth;

use MasterCard\Core\ApiConfig;
use MasterCard\Core\Util;
use MasterCard\Core\Security\AuthenticationInterface;
use MasterCard\Core\Security\SecurityUtil;
use MasterCard\Core\Security\OAuth\OAuthParameters;
use MasterCard\Core\Model\RequestMap;
use PHPUnit\Framework\TestCase;

class OAuthUtilTest extends TestCase {

    protected $oauthAuthentication;
    
    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/fake-key.p12");
        $this->oauthAuthentication = new OAuthAuthentication("DuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM!qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU", $privateKey, "fake-key", "fakepassword");
        ApiConfig::setAuthentication($this->oauthAuthentication);
    }

    public function testGetNonce() {
        $nonce = SecurityUtil::getNonce();
        $this->assertNotNull($nonce);
        $this->assertSame(16, strlen($nonce));
    }

    public function testGetTimestamp() {
        $nonce = SecurityUtil::getTimestamp();
        $this->assertNotNull($nonce);
        $this->assertSame(10, strlen($nonce));
    }


    public function testGenerateSignature() {
        $body = "{ \"name\":\"andrea\", \"surname\":\"rizzini\" }";
        $method = "POST";
        $url = "http://www.andrea.rizzini.com/simple_service";

        $oAuthParameters = new OAuthParameters ();
        $oAuthParameters->setOAuthConsumerKey($this->oauthAuthentication->getClientId());
        $oAuthParameters->setOAuthNonce("NONCE");
        $oAuthParameters->setOAuthTimestamp("TIMESTAMP");
        $oAuthParameters->setOAuthSignatureMethod("RSA-SHA1");

        if (!empty($body)) {
            $encodedHash = Util::base64Encode(Util::sha1Encode($body, true));
            $oAuthParameters->setOAuthBodyHash($encodedHash);
        }

        $baseString = OAuthAuthentication::getOAuthBaseString($url, $method, $oAuthParameters->getBaseParameters());
        $this->assertEquals("POST&http%3A%2F%2Fwww.andrea.rizzini.com%2Fsimple_service&oauth_body_hash%3DapwbAT6IoMRmB9wE9K4fNHDsaMo%253D%26oauth_consumer_key%3DDuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM%2521qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU%26oauth_nonce%3DNONCE%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3DTIMESTAMP", $baseString);

        
        
        $signature = $this->oauthAuthentication->signValue($baseString);
        $this->assertEquals("CL/B3OkUsVOXE7tbIrM1DLLh3fC2xigxTFq3lkw3P65FBrw5wbVymygumKFBp9CpUEwMZpV0jHT1YFbA+d+6uK64E46be2SEtLAKZ8Z3wFPkmm8k6OrYWWGvvcY7UtDGihGxRb3Yoa/uT1FNw/3VWV31PKef/iDfzoGcFAaw21UcVnfTdgJrhBDIqLZcWtGhSGzXBN37ZjgOwBKaphqOZ5Bcu16XCTjNKGU5+y1/Ce8kc1NzKmNK+P+LO1xHrACOGmYCpk49q913sUcEeEmcjVPDLm1YIxPSdkq4ZFfekVoClC/rpmJnGTUfaIFcTS8PkBr1mgPSynMFK/SF4Uj/PQ==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("DuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM!qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU", $baseParams['oauth_consumer_key']);
        $this->assertEquals("NONCE", $baseParams['oauth_nonce']);
        $this->assertEquals("CL/B3OkUsVOXE7tbIrM1DLLh3fC2xigxTFq3lkw3P65FBrw5wbVymygumKFBp9CpUEwMZpV0jHT1YFbA+d+6uK64E46be2SEtLAKZ8Z3wFPkmm8k6OrYWWGvvcY7UtDGihGxRb3Yoa/uT1FNw/3VWV31PKef/iDfzoGcFAaw21UcVnfTdgJrhBDIqLZcWtGhSGzXBN37ZjgOwBKaphqOZ5Bcu16XCTjNKGU5+y1/Ce8kc1NzKmNK+P+LO1xHrACOGmYCpk49q913sUcEeEmcjVPDLm1YIxPSdkq4ZFfekVoClC/rpmJnGTUfaIFcTS8PkBr1mgPSynMFK/SF4Uj/PQ==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("TIMESTAMP", $baseParams['oauth_timestamp']);
        
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo%3D", Util::uriRfc3986Encode($baseParams['oauth_body_hash']));
        $this->assertEquals("DuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM%21qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU", Util::uriRfc3986Encode($baseParams['oauth_consumer_key']));
        $this->assertEquals("NONCE", Util::uriRfc3986Encode($baseParams['oauth_nonce'] ));
        $this->assertEquals("CL%2FB3OkUsVOXE7tbIrM1DLLh3fC2xigxTFq3lkw3P65FBrw5wbVymygumKFBp9CpUEwMZpV0jHT1YFbA%2Bd%2B6uK64E46be2SEtLAKZ8Z3wFPkmm8k6OrYWWGvvcY7UtDGihGxRb3Yoa%2FuT1FNw%2F3VWV31PKef%2FiDfzoGcFAaw21UcVnfTdgJrhBDIqLZcWtGhSGzXBN37ZjgOwBKaphqOZ5Bcu16XCTjNKGU5%2By1%2FCe8kc1NzKmNK%2BP%2BLO1xHrACOGmYCpk49q913sUcEeEmcjVPDLm1YIxPSdkq4ZFfekVoClC%2FrpmJnGTUfaIFcTS8PkBr1mgPSynMFK%2FSF4Uj%2FPQ%3D%3D",
                 Util::uriRfc3986Encode($baseParams['oauth_signature']));
        $this->assertEquals("RSA-SHA1", Util::uriRfc3986Encode($baseParams['oauth_signature_method']));
        $this->assertEquals("TIMESTAMP", Util::uriRfc3986Encode($baseParams['oauth_timestamp']) );
        
        
    }
    
    public function testOauthSignatureFromCSharpExample()
    {
        $baseMap = new RequestMap();
        $baseMap->set("AccountInquiry.AccountNumber", "5343434343434343");
        
        
        $method = "PUT";
        $body = json_encode($baseMap->getBaseMapAsArray());
        $this->assertEquals('{"AccountInquiry":{"AccountNumber":"5343434343434343"}}', $body);
        $url = "https://sandbox.api.mastercard.com/fraud/loststolen/v1/account-inquiry?Format=JSON";
        
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/loststolen/v1/account-inquiry?Format=JSON", $url);

        
        $oAuthParameters = new OAuthParameters ();
        $oAuthParameters->setOAuthConsumerKey($this->oauthAuthentication->getClientId());
        $oAuthParameters->setOAuthNonce("Fl0qGYY1ZmwMzzpdN");
        $oAuthParameters->setOAuthTimestamp("1457428003");
        $oAuthParameters->setOAuthSignatureMethod("RSA-SHA1");

        if (!empty($body)) {
            $encodedHash = Util::base64Encode(Util::sha1Encode($body, true));
            $oAuthParameters->setOAuthBodyHash($encodedHash);
        }

        $baseString = OAuthAuthentication::getOAuthBaseString($url, $method, $oAuthParameters->getBaseParameters());
        $this->assertEquals("PUT&https%3A%2F%2Fsandbox.api.mastercard.com%2Ffraud%2Floststolen%2Fv1%2Faccount-inquiry&Format%3DJSON%26oauth_body_hash%3DnmtgpSOebxR%252FPfZyg9qwNoUEsYY%253D%26oauth_consumer_key%3DDuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM%2521qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU%26oauth_nonce%3DFl0qGYY1ZmwMzzpdN%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3D1457428003", $baseString);

        $signature = $this->oauthAuthentication->signValue($baseString);
        $this->assertEquals("wT30diu3fP2biXpw66pmz68gSasAEVHhTrJZkMxDVmHwheYQNYD0ZCWW34aEdA0HFrQNWI8utAUKcaHpw+lxCBZRg1VMcjeuvIH4gerDRKGmi18CWoKSb3lZ0fiFLphq8maukaNQC1niZo33PNGMEJ2RKrA7YUxo8VEAgOTaRuB4SMqznkjvZoNRDSxBccvTB+HgLIHKHGt5MqvuOG2szVvfDgF1VBLAEMdBlTTXDIxcIYyRj1kQ5WHOmMfCuKWxnm/wyjxlDYZnRXJhmsehOao/aDNzYSZPu/lwsdWAprvIBN34xp/zNpTtKFukx7M84DrLprFRlgYzKjFPyO9eCw==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        $this->assertEquals("nmtgpSOebxR/PfZyg9qwNoUEsYY=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("DuEVInT1ASB7AN7grP2Wd8t6Tpg31uYUlSTzoofYxP92pgyM!qkNEwNPSA0MnulBO6jTFt7cuIOgN3BnEAgvWcAeb1Z84bgqU", $baseParams['oauth_consumer_key']);
        $this->assertEquals("Fl0qGYY1ZmwMzzpdN", $baseParams['oauth_nonce']);
        $this->assertEquals("wT30diu3fP2biXpw66pmz68gSasAEVHhTrJZkMxDVmHwheYQNYD0ZCWW34aEdA0HFrQNWI8utAUKcaHpw+lxCBZRg1VMcjeuvIH4gerDRKGmi18CWoKSb3lZ0fiFLphq8maukaNQC1niZo33PNGMEJ2RKrA7YUxo8VEAgOTaRuB4SMqznkjvZoNRDSxBccvTB+HgLIHKHGt5MqvuOG2szVvfDgF1VBLAEMdBlTTXDIxcIYyRj1kQ5WHOmMfCuKWxnm/wyjxlDYZnRXJhmsehOao/aDNzYSZPu/lwsdWAprvIBN34xp/zNpTtKFukx7M84DrLprFRlgYzKjFPyO9eCw==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("1457428003", $baseParams['oauth_timestamp']);
       
        
    }
 
    

}

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
use MasterCard\Core\Security\OAuth\OAuthUtil;
use MasterCard\Core\Security\OAuth\OAuthParameters;
use MasterCard\Core\Model\BaseMap;

class OAuthUtilTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/prod_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $privateKey, "alias", "password"));
    }

    public function testGetNonce() {
        $nonce = OAuthUtil::getNonce();
        $this->assertNotNull($nonce);
        $this->assertTrue(strlen($nonce) == 16);
    }

    public function testGetTimestamp() {
        $nonce = OAuthUtil::getTimestamp();
        $this->assertNotNull($nonce);
        $this->assertTrue(strlen($nonce) == 10);
    }


    public function testGenerateSignature() {
        $body = "{ \"name\":\"andrea\", \"surname\":\"rizzini\" }";
        $method = "POST";
        $url = "http://www.andrea.rizzini.com/simple_service";

        $oAuthParameters = new OAuthParameters ();
        $oAuthParameters->setOAuthConsumerKey(ApiConfig::getAuthentication()->getClientId());
        $oAuthParameters->setOAuthNonce("NONCE");
        $oAuthParameters->setOAuthTimestamp("TIMESTAMP");
        $oAuthParameters->setOAuthSignatureMethod("RSA-SHA1");

        if (!empty($body)) {
            $encodedHash = Util::base64Encode(Util::sha1Encode($body, true));
            $oAuthParameters->setOAuthBodyHash($encodedHash);
        }

        $baseString = OAuthUtil::getBaseString($url, $method, $oAuthParameters->getBaseParameters());
        $this->assertEquals("POST&http%3A%2F%2Fwww.andrea.rizzini.com%2Fsimple_service&oauth_body_hash%3DapwbAT6IoMRmB9wE9K4fNHDsaMo%253D%26oauth_consumer_key%3DgVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6%2521414b543630362f426b4f6636415a5973656c33735661383d%26oauth_nonce%3DNONCE%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3DTIMESTAMP", $baseString);

        $signature = OAuthUtil::rsaSign($baseString);
        $this->assertEquals("CQJfOX6Yebd7KPPsG7cRopzt+4/QB+GiMQhgcFMw+ew2bWtBLj+t8i6mSe26eEVurxzF4mp0uvjXZzz8Ik5YLjP1byr0v+wsMmAQbWUTj4dO7k8W2+a4AISmKFfbSEUaDgBpPyCl72cL29+hoTNo/usD0EYpaX6P1Vo+EYLbZjK3ZJRtDSd8VZnjxKInUoNI8VvJuGgZ3u7nh5caXvVk6RlCbgwdVEKAv/BsfLSQEgc0/DCCKhX2ZnNOqJJ3FRS6s4bAbqYbui5ouWN5SGkcRaYPt7Fi8oTu561oNZ02HlAWL9m0fp8MK6ZDGQjkeC+zWeo/o0Gbc+/kKGPdOrCNFA==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $baseParams['oauth_consumer_key']);
        $this->assertEquals("NONCE", $baseParams['oauth_nonce']);
        $this->assertEquals("CQJfOX6Yebd7KPPsG7cRopzt+4/QB+GiMQhgcFMw+ew2bWtBLj+t8i6mSe26eEVurxzF4mp0uvjXZzz8Ik5YLjP1byr0v+wsMmAQbWUTj4dO7k8W2+a4AISmKFfbSEUaDgBpPyCl72cL29+hoTNo/usD0EYpaX6P1Vo+EYLbZjK3ZJRtDSd8VZnjxKInUoNI8VvJuGgZ3u7nh5caXvVk6RlCbgwdVEKAv/BsfLSQEgc0/DCCKhX2ZnNOqJJ3FRS6s4bAbqYbui5ouWN5SGkcRaYPt7Fi8oTu561oNZ02HlAWL9m0fp8MK6ZDGQjkeC+zWeo/o0Gbc+/kKGPdOrCNFA==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("TIMESTAMP", $baseParams['oauth_timestamp']);
        
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo%3D", Util::uriRfc3986Encode($baseParams['oauth_body_hash']));
        $this->assertEquals("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6%21414b543630362f426b4f6636415a5973656c33735661383d", Util::uriRfc3986Encode($baseParams['oauth_consumer_key']));
        $this->assertEquals("NONCE", Util::uriRfc3986Encode($baseParams['oauth_nonce'] ));
        $this->assertEquals("CQJfOX6Yebd7KPPsG7cRopzt%2B4%2FQB%2BGiMQhgcFMw%2Bew2bWtBLj%2Bt8i6mSe26eEVurxzF4mp0uvjXZzz8Ik5YLjP1byr0v%2BwsMmAQbWUTj4dO7k8W2%2Ba4AISmKFfbSEUaDgBpPyCl72cL29%2BhoTNo%2FusD0EYpaX6P1Vo%2BEYLbZjK3ZJRtDSd8VZnjxKInUoNI8VvJuGgZ3u7nh5caXvVk6RlCbgwdVEKAv%2FBsfLSQEgc0%2FDCCKhX2ZnNOqJJ3FRS6s4bAbqYbui5ouWN5SGkcRaYPt7Fi8oTu561oNZ02HlAWL9m0fp8MK6ZDGQjkeC%2BzWeo%2Fo0Gbc%2B%2FkKGPdOrCNFA%3D%3D",
                 Util::uriRfc3986Encode($baseParams['oauth_signature']));
        $this->assertEquals("RSA-SHA1", Util::uriRfc3986Encode($baseParams['oauth_signature_method']));
        $this->assertEquals("TIMESTAMP", Util::uriRfc3986Encode($baseParams['oauth_timestamp']) );
        
        
    }
    
    public function testOauthSignatureFromCSharpExample()
    {
        $baseMap = new BaseMap();
        $baseMap->set("AccountInquiry.AccountNumber", "5343434343434343");
        
        
        $method = "PUT";
        $body = json_encode($baseMap->getProperties());
        $this->assertEquals('{"AccountInquiry":{"AccountNumber":"5343434343434343"}}', $body);
        $url = "https://sandbox.api.mastercard.com/fraud/loststolen/v1/account-inquiry?Format=JSON";
        
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/loststolen/v1/account-inquiry?Format=JSON", $url);

        
        $oAuthParameters = new OAuthParameters ();
        $oAuthParameters->setOAuthConsumerKey(ApiConfig::getAuthentication()->getClientId());
        $oAuthParameters->setOAuthNonce("Fl0qGYY1ZmwMzzpdN");
        $oAuthParameters->setOAuthTimestamp("1457428003");
        $oAuthParameters->setOAuthSignatureMethod("RSA-SHA1");

        if (!empty($body)) {
            $encodedHash = Util::base64Encode(Util::sha1Encode($body, true));
            $oAuthParameters->setOAuthBodyHash($encodedHash);
        }

        $baseString = OAuthUtil::getBaseString($url, $method, $oAuthParameters->getBaseParameters());
        $this->assertEquals("PUT&https%3A%2F%2Fsandbox.api.mastercard.com%2Ffraud%2Floststolen%2Fv1%2Faccount-inquiry&Format%3DJSON%26oauth_body_hash%3DnmtgpSOebxR%252FPfZyg9qwNoUEsYY%253D%26oauth_consumer_key%3DgVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6%2521414b543630362f426b4f6636415a5973656c33735661383d%26oauth_nonce%3DFl0qGYY1ZmwMzzpdN%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3D1457428003", $baseString);

        $signature = OAuthUtil::rsaSign($baseString);
        $this->assertEquals("ABImx5hGm9RK6o3ipHc2/RH0bMfVe5GRBmI8Y6mwn+5pZQgayr0XyFBBK4fkHpWS8LCytadX09qMG7gCfSl9qyM27l5spf164y6L/GSbvmsYgvd7WAkinwf+0LsSc1sZgytDVLCHXFRofFliugf1ttE4ErrzpDi7Bm2Em6xHF8XVokFMpRj2euddCoJBklamIoG0JvE0Xo/qZ9Do16BITEv5t47UhM0XHoBNiKP2X0uZQ//xGGKJLbMGumDkvO7lAHDEtp7VLrKB/Kx3ebNpXh0Mygyla3oIjg7boDL90lG/M1L8cvPhtahfaZ1ot0IjAntUSZ8BGqW2AzHy7WYYwQ==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        $this->assertEquals("nmtgpSOebxR/PfZyg9qwNoUEsYY=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $baseParams['oauth_consumer_key']);
        $this->assertEquals("Fl0qGYY1ZmwMzzpdN", $baseParams['oauth_nonce']);
        $this->assertEquals("ABImx5hGm9RK6o3ipHc2/RH0bMfVe5GRBmI8Y6mwn+5pZQgayr0XyFBBK4fkHpWS8LCytadX09qMG7gCfSl9qyM27l5spf164y6L/GSbvmsYgvd7WAkinwf+0LsSc1sZgytDVLCHXFRofFliugf1ttE4ErrzpDi7Bm2Em6xHF8XVokFMpRj2euddCoJBklamIoG0JvE0Xo/qZ9Do16BITEv5t47UhM0XHoBNiKP2X0uZQ//xGGKJLbMGumDkvO7lAHDEtp7VLrKB/Kx3ebNpXh0Mygyla3oIjg7boDL90lG/M1L8cvPhtahfaZ1ot0IjAntUSZ8BGqW2AzHy7WYYwQ==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("1457428003", $baseParams['oauth_timestamp']);
       
        
    }
 
    

}

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
        $privateKey = file_get_contents(getcwd()."/mcapi_sandbox_key.p12");
        $this->oauthAuthentication = new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password");
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
        $this->assertEquals("POST&http%3A%2F%2Fwww.andrea.rizzini.com%2Fsimple_service&oauth_body_hash%3DapwbAT6IoMRmB9wE9K4fNHDsaMo%253D%26oauth_consumer_key%3DL5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279%252150596e52466e3966546d434b7354584c4975693238513d3d%26oauth_nonce%3DNONCE%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3DTIMESTAMP", $baseString);

        
        
        $signature = $this->oauthAuthentication->signValue($baseString);
        $this->assertEquals("7cu8PjbG9LCv4BmG9qOJft/wfkrEhQzDbHkEQ8zdBrgFvJ+RbPL3s2jRjoioXYw1tJzSnIfknksfc66fBMc6fURRRy2zUQlXU8q6Xun0l4islF99s8whmbkiYmVAfsnVokbAidCXxQxkCinFSn0Y+fun6Re3UzL7cHPzFSCW7kVB7+KNyVPEMT7xKy4dnfIwYoHesfGr4uWZfag8k8PQtI/j5ankb7FVXMAWoFnIYAIZuVRRocLK6cPPmYs0hLoJWIZN8WISdYBGXFD7fAwCy6OlyJPj7IHxtO/ROl4LI8tkmOkm6+ltxBZgU+N6tlVPfxBPF1JFftylyCbvDJzZYg==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $baseParams['oauth_consumer_key']);
        $this->assertEquals("NONCE", $baseParams['oauth_nonce']);
        $this->assertEquals("7cu8PjbG9LCv4BmG9qOJft/wfkrEhQzDbHkEQ8zdBrgFvJ+RbPL3s2jRjoioXYw1tJzSnIfknksfc66fBMc6fURRRy2zUQlXU8q6Xun0l4islF99s8whmbkiYmVAfsnVokbAidCXxQxkCinFSn0Y+fun6Re3UzL7cHPzFSCW7kVB7+KNyVPEMT7xKy4dnfIwYoHesfGr4uWZfag8k8PQtI/j5ankb7FVXMAWoFnIYAIZuVRRocLK6cPPmYs0hLoJWIZN8WISdYBGXFD7fAwCy6OlyJPj7IHxtO/ROl4LI8tkmOkm6+ltxBZgU+N6tlVPfxBPF1JFftylyCbvDJzZYg==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("TIMESTAMP", $baseParams['oauth_timestamp']);
        
        
        $this->assertEquals("apwbAT6IoMRmB9wE9K4fNHDsaMo%3D", Util::uriRfc3986Encode($baseParams['oauth_body_hash']));
        $this->assertEquals("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279%2150596e52466e3966546d434b7354584c4975693238513d3d", Util::uriRfc3986Encode($baseParams['oauth_consumer_key']));
        $this->assertEquals("NONCE", Util::uriRfc3986Encode($baseParams['oauth_nonce'] ));
        $this->assertEquals("7cu8PjbG9LCv4BmG9qOJft%2FwfkrEhQzDbHkEQ8zdBrgFvJ%2BRbPL3s2jRjoioXYw1tJzSnIfknksfc66fBMc6fURRRy2zUQlXU8q6Xun0l4islF99s8whmbkiYmVAfsnVokbAidCXxQxkCinFSn0Y%2Bfun6Re3UzL7cHPzFSCW7kVB7%2BKNyVPEMT7xKy4dnfIwYoHesfGr4uWZfag8k8PQtI%2Fj5ankb7FVXMAWoFnIYAIZuVRRocLK6cPPmYs0hLoJWIZN8WISdYBGXFD7fAwCy6OlyJPj7IHxtO%2FROl4LI8tkmOkm6%2BltxBZgU%2BN6tlVPfxBPF1JFftylyCbvDJzZYg%3D%3D",
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
        $this->assertEquals("PUT&https%3A%2F%2Fsandbox.api.mastercard.com%2Ffraud%2Floststolen%2Fv1%2Faccount-inquiry&Format%3DJSON%26oauth_body_hash%3DnmtgpSOebxR%252FPfZyg9qwNoUEsYY%253D%26oauth_consumer_key%3DL5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279%252150596e52466e3966546d434b7354584c4975693238513d3d%26oauth_nonce%3DFl0qGYY1ZmwMzzpdN%26oauth_signature_method%3DRSA-SHA1%26oauth_timestamp%3D1457428003", $baseString);

        $signature = $this->oauthAuthentication->signValue($baseString);
        $this->assertEquals("9CxMg0Dd4bOJbwftfkd+Gubxg0t4ovU6SznJQs91VU3x4xLDKxI66xCWc7IdkdG0sIVXuDK3vxcht6UEwHIg8KxQKqS9d5Od9QrYyfHDsz0Zyy+gwkNNV/oStokX5SWLUVMv94FO5QM5soibbLgoh5aTvDeZtMWkeTGu1LIvake7vxG+NC6kvGAHkmJwNB92XOsIQ2PUgpjtfvG02OLwsepleNY7hFOA9lyD5cNNijU43Xzfn7IFWGS6+fZ5UaJhvy9SbqnGMajURByXteHB48kpndBvNSmGn16w4IMEhQ9MemuigeAguMllgmMxsrpFCCmFGS6jo9IZlGzKfOGK/g==", $signature);
        $oAuthParameters->setOAuthSignature($signature);
        
        $baseParams = $oAuthParameters->getBaseParameters();
        $this->assertEquals(['oauth_body_hash', 'oauth_consumer_key', 'oauth_nonce', 'oauth_signature', 'oauth_signature_method', 'oauth_timestamp'], array_keys($baseParams));
        $this->assertEquals("nmtgpSOebxR/PfZyg9qwNoUEsYY=", $baseParams['oauth_body_hash'] );
        $this->assertEquals("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $baseParams['oauth_consumer_key']);
        $this->assertEquals("Fl0qGYY1ZmwMzzpdN", $baseParams['oauth_nonce']);
        $this->assertEquals("9CxMg0Dd4bOJbwftfkd+Gubxg0t4ovU6SznJQs91VU3x4xLDKxI66xCWc7IdkdG0sIVXuDK3vxcht6UEwHIg8KxQKqS9d5Od9QrYyfHDsz0Zyy+gwkNNV/oStokX5SWLUVMv94FO5QM5soibbLgoh5aTvDeZtMWkeTGu1LIvake7vxG+NC6kvGAHkmJwNB92XOsIQ2PUgpjtfvG02OLwsepleNY7hFOA9lyD5cNNijU43Xzfn7IFWGS6+fZ5UaJhvy9SbqnGMajURByXteHB48kpndBvNSmGn16w4IMEhQ9MemuigeAguMllgmMxsrpFCCmFGS6jo9IZlGzKfOGK/g==", $baseParams['oauth_signature']);
        $this->assertEquals("RSA-SHA1", $baseParams['oauth_signature_method']);
        $this->assertEquals("1457428003", $baseParams['oauth_timestamp']);
       
        
    }
 
    

}

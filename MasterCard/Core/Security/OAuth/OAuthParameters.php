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

class OAuthParameters
{
    const OAUTH_BODY_HASH_KEY = "oauth_body_hash";
    const OAUTH_CALLBACK_KEY = "oauth_callback";
    const OAUTH_CONSUMER_KEY = "oauth_consumer_key";
    const OAUTH_CONSUMER_SECRET = "oauth_consumer_secret";
    const OAUTH_NONCE_KEY = "oauth_nonce";
    const OAUTH_KEY = "OAuth";
    const AUTHORIZATION = "Authorization";
    const OAUTH_SIGNATURE_KEY = "oauth_signature";
    const OAUTH_SIGNATURE_METHOD_KEY = "oauth_signature_method";
    const OAUTH_TIMESTAMP_KEY = "oauth_timestamp";
    const OAUTH_TOKEN_KEY = "oauth_token";
    const OAUTH_TOKEN_SECRET_KEY = "oauth_token_secret";
    const OAUTH_VERIFIER_KEY = "oauth_verifier";
    const REALM_KEY = "realm";
    const XOAUTH_REQUESTOR_ID_KEY = "xoauth_requestor_id";
    
    protected $baseParameters = array();
        
    private function put($key, $value) {
        $this->baseParameters[$key] =  $value;
    }
    
    public function setOAuthConsumerKey($consumerKey) {
        $this->put(self::OAUTH_CONSUMER_KEY, $consumerKey);
    }

    public function setOAuthNonce($oauthNonce) {
        $this->put(self::OAUTH_NONCE_KEY, $oauthNonce);
    }

    public function setOAuthTimestamp($timestamp) {
        $this->put(self::OAUTH_TIMESTAMP_KEY, $timestamp);
    }

    public function setOAuthSignatureMethod($signatureMethod) {
        $this->put(self::OAUTH_SIGNATURE_METHOD_KEY, $signatureMethod);
    }

    public function setOAuthSignature($signature) {
        $this->put(self::OAUTH_SIGNATURE_KEY, $signature);
    }

    public function setOAuthBodyHash($bodyHash) {
        $this->put(self::OAUTH_BODY_HASH_KEY, $bodyHash);
    }

    
    public function getBaseParameters() {
        ksort($this->baseParameters);
        return $this->baseParameters;
    }

}
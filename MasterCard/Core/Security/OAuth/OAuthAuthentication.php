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

use MasterCard\Core\Security\AuthenticationInterface;
use \MasterCard\Core\Util;

class OAuthAuthentication implements AuthenticationInterface
{
    
    protected $clientId;
    protected $privateKey;
    protected $alias;
    protected $password;


    public function __construct($clientId, $privateKey, $alias, $password) {
        $this->clientId = $clientId;
        $this->privateKey = $privateKey;
        $this->alias = $alias;
        $this->password = $password;
    }
    
    public function getClientId() {
        return $this->clientId;
    }

    public function getPrivateKey() {
        return $this->privateKey;
    }

    public function signRequest($uri, $request) {
        $method = $request->getMethod();
        $body = $request->getBody()->getContents();
        
        return $request->withHeader(OAuthParameters::AUTHORIZATION, OAuthUtil::getOAuthKey($uri, $method, $body));
    }
    
    public function signMessage($message) {
        
        openssl_pkcs12_read($this->privateKey, $certs, $this->password);
        $pkeyid = openssl_get_privatekey($certs["pkey"]);
        openssl_sign($message, $signature, $pkeyid , "sha1");
        return $signature;
    }


}
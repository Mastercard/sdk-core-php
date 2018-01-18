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


namespace MasterCard\Core\Model;

class Environment {
    const PRODUCTION = "production";
    const PRODUCTION_MTF = "production_mtf";
    const PRODUCTION_ITF = "production_itf";
    const SANDBOX = "sandbox"; 
    const SANDBOX_STATIC = "sandbox_static"; 
    const SANDBOX_MTF = "sandbox_mtf"; 
    const SANDBOX_ITF = "sandbox_itf"; 
    const STAGE = "stage";
    const STAGE_MTF = "stage_mtf";
    const STAGE_ITF = "stage_itf";
    const DEV = "dev";
    const LOCALHOST = "localhost";
    const OTHER = "other";
    const ITF = "itf";
    const PERF = "perf";
    
    
    public static $MAPPING = [
        Environment::PRODUCTION => ["https://api.mastercard.com", null],
        Environment::PRODUCTION_MTF => ["https://api.mastercard.com", "mtf"],
        Environment::PRODUCTION_ITF => ["https://api.mastercard.com", "itf"],
        Environment::SANDBOX => ["https://sandbox.api.mastercard.com", null],
        Environment::SANDBOX_STATIC => ["https://sandbox.api.mastercard.com", "static"],
        Environment::SANDBOX_MTF => ["https://sandbox.api.mastercard.com", "mtf"],
        Environment::SANDBOX_ITF => ["https://sandbox.api.mastercard.com", "itf"],
        Environment::STAGE => ["https://stage.api.mastercard.com", null],
        Environment::STAGE_MTF => ["https://stage.api.mastercard.com", "mtf"],
        Environment::STAGE_ITF => ["https://stage.api.mastercard.com", "itf"],
        Environment::DEV => ["https://dev.api.mastercard.com", null],
        Environment::LOCALHOST => ["http://localhost:8081", null],
        Environment::ITF => ["https://itf.api.mastercard.com", null],
        Environment::PERF => ["https://perf.api.mastercard.com", null]
    ];
    
}


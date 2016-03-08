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

namespace MasterCard\Core;

class Util {
    
    
    /**
     * NormalizeUrl 
     * @param type $requestUrl
     * @return String
     */
    public static function normalizeUrl($requestUrl)
    {
        $urlParts = parse_url($requestUrl);
        if ($urlParts != FALSE) {
            $format = '%s://%s%s';
            $formattedUrl = vsprintf($format, array_values($urlParts));
            return $formattedUrl;
        }
        else {
            return null;
        }
   
    }
    
    /**
     * 
     * @param type $requestUrl
     * @param type $requestParameteMap
     * @return string
     */
    public static function normalizeParameters($requestUrl, $requestParameteMap)
    {
        $requestParameteMapCopy = array_merge(array(), $requestParameteMap);
        
        $query = parse_url($requestUrl, PHP_URL_QUERY);
        if ($query != FALSE) {
            parse_str($query, $params);
            foreach ($params as $key => $value) {
                $requestParameteMapCopy[$key] = $value;
            }
        }
        
        
        ksort($requestParameteMapCopy);
        
        $stringBuilder = "";
        foreach ($requestParameteMapCopy as $key => $value) {
            if (strlen($stringBuilder) > 0) {
                $stringBuilder .= "&";
            }
            $stringBuilder .= self::uriRfc3986Encode($key)."=".self::uriRfc3986Encode($value);
        }
        return $stringBuilder;       
    }
    
    public static function base64Encode($data)
    {
        return base64_encode (  $data );
    }
    
    public static function sha1Encode($data, $raw_output = false)
    {
        return sha1( $data, $raw_output );
    }
    
    public static function urlEncode($data)
    {
        return rawurlencode( $data );
    }
    
    public static function uriRfc3986Encode($value)
    {
        //return str_replace('%7E', '~', rawurlencode($value));
        return rawurlencode($value);
    }
}
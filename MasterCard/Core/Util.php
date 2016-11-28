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
            $paddedValues = array_pad(array_values($urlParts), 3, "/");
            $formattedUrl = vsprintf($format,$paddedValues);
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
    
    /**
     * This method is used to generate a sumMap by taking a subset of the map 
     * which contains the key specified in the list
     * @param type $inputMap
     * @param type $keyList
     * @return type
     */
    public static function subMap(&$inputMap, $keyList) {
        $subMap = array();
        foreach ($keyList as $key)
        {
            //check is the map contain the 
            if (array_key_exists($key, $inputMap)){
                $subMap[$key] = $inputMap[$key];
                unset($inputMap[$key]);
            }
        }
        
        return $subMap;
    }
    
    /**
     * Replace the path which contains {variable_id} by taking values from map
     * @param type $path
     * @param type $inputMap
     */
    public static function getReplacedPath($path, &$inputMap)  {
        
        $pattern = '/{(.*?)}/';
        $result = $path;
        preg_match_all($pattern, $path, $matches);
        
        foreach ($matches[1] as $key) {
            if (array_key_exists ( $key , $inputMap )) {
                $result = str_replace("{".$key."}", $inputMap[$key], $result);
                unset($inputMap[$key]);
            } else {
                throw new \Exception ("Error, path paramer: '$key' expected but not found in input map");
            }
        }
        return $result;
        
        
    }
    
    /**
     * base64Encode
     * @param type $data
     * @return type
     */
    public static function base64Encode($data)
    {
        return base64_encode (  $data );
    }
    
    /**
     * sha1Encode
     * @param type $data
     * @param type $raw_output
     * @return type
     */
    public static function sha256Encode($data, $raw_output = false)
    {
        return hash('sha256', $data, $raw_output);
    }
    
    /**
     * sha256Encode
     * @param type $data
     * @param type $raw_output
     * @return type
     */
    public static function sha1Encode($data, $raw_output = false)
    {
        return sha1( $data, $raw_output );
    }
    
    /**
     * urlEncode
     * @param type $data
     * @return type
     */
    public static function urlEncode($data)
    {
        return rawurlencode( $data );
    }
    
    /**
     * uriRfc3986Encode
     * @param type $value
     * @return type
     */
    public static function uriRfc3986Encode($value)
    {
        //return str_replace('%7E', '~', rawurlencode($value));
        return rawurlencode($value);
    }
}
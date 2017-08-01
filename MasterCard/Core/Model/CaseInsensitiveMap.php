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

/**
 * Base class for all domain objects.
 */
class CaseInsensitiveMap extends SmartMap {
    /**
     * This gets the value in the map associated with the key
     * @param type $key
     * @return value
     */
    public function get($key)
    {
        return parent::get(strtolower($key));
    }
    
        /**
     * This check is the map contains a key
     * @param type $key
     * @return boolean true or false
     */
    public function containsKey($key)
    {
        return parent::containsKey(strtolower($key));
    }
    
    /**
     * 
     * @param type $key
     * @param type $value
     * @return \MasterCard\Core\Model\RequestMap
     */
    public function set($key, $value) {
        parent::set(strtolower($key), $value);
    }
    
    /**
     * Updates the object's properties with the values in the specified map.
     * @param $map array Map of values to set.
     */
    public function setAll($map) {
        $this->properties = $this->parseMap($map);
    }
    
    
    private function parseMap($map) {
        $result = array();
        foreach ($map as $key => $value) {
            if ($this->isAssoc($value)) {
                //this is a map
                $result[strtolower($key)] = $this->parseMap($value);
            } else if (is_array ($value)){
                //this is a list
                $result[strtolower($key)] = $this->parseList($value);
            } else {
                /// this is a simple value
                $result[strtolower($key)] = $value;
            }
        }
        return $result;
    }
    
    private function parseList($list) {
        $result = array();
        foreach ($list as $key => $value) {
            if (parent::isAssoc($value)) {
                $result[] = $this->parseMap($value);
            } else if (is_array ($value)) {
                $result[] = $this->parseList($value);
            } else {
                $result[] = $value;
            }
        }
        return $result;
    }
    
    protected function isAssoc($arr)
    {
        return is_array($arr) && (array_keys($arr) !== range(0, count($arr) - 1));
    }

}
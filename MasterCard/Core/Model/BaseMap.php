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
class BaseMap {

    private $properties = array();
    
    /**
     * This gets the value in the map associated with the key
     * @param type $key
     * @return value
     */
    public function get($key)
    {
        if (strpos($key, ".") !== false) {
            //we have a dot, we need to split the ket by the dot and check
            //individual string if they are part of the nestes array
            $keys = explode('.', $key);
            $keysCount = count($keys);
            
            $tmpArray = $this->properties;
            foreach ($keys as $index=>$subKey) {
                if ($index+1 < $keysCount)
                {
                    //arizzini: if the current $index is not the last $subKey
                    //we want to the last nested map
                    if (array_key_exists($subKey, $tmpArray) && is_array($tmpArray[$subKey]) ) {
                        $tmpArray = $tmpArray[$subKey];
                    } else {
                        return null;
                    }
                }
                else {
                    //arizzini: this is the last key we need to 
                    //check if it is contained in the $tmpArray ans then
                    // return it
                    if (array_key_exists($subKey, $tmpArray))
                    {
                        return $tmpArray[$subKey];
                    } else {
                        return null;
                    }
                    
                }
            }
            
            return null;
            
            
        } else {
            if (array_key_exists($key, $this->properties)) {
                return $this->properties[$key];
            } else {
                return null;
            }
        }   
        
    }
    
    /**
     * This check is the map contains a key
     * @param type $key
     * @return boolean true or false
     */
    public function containsKey($key)
    {
        if (strpos($key, ".") !== false) {
            //we have a dot, we need to split the ket by the dot and check
            //individual string if they are part of the nestes array
            $keys = explode('.', $key);
            $keysCount = count($keys);
            
            
            $tmpArray = $this->properties;
            foreach ($keys as $index=>$subKey) {
                if ($index+1 < $keysCount)
                {
                    //arizzini: if the current $index is not the last $subKey
                    //we want to check is the $tmpArray is an array
                    if (is_array($tmpArray) && array_key_exists($subKey, $tmpArray)) {
                        $tmpArray = $tmpArray[$subKey];
                    } else {
                        return false;                    
                    }
                }
                else {
                    return array_key_exists($subKey, $tmpArray);
                }
            }
            
            return false;
            
        } else {
            return array_key_exists($key, $this->properties);
        }
        
    }
    
    /**
     * 
     * @param type $key
     * @param type $value
     * @return \MasterCard\Core\Model\BaseMap
     */
    public function set($key, $value) {
        if (strpos($key, ".") !== false) {
            //we have a dot, we need to split the ket by the dot and check
            //individual string if they are part of the nestes array
            $keys = explode('.', $key);
            $keysCount = count($keys);
                    
            $tmpArray = &$this->properties;
            foreach ($keys as $index=>$subKey) {
                if (($index+1) < $keysCount)
                {
                    if (!array_key_exists($subKey, $tmpArray)) {
                        $tmpArray[$subKey] = array();
                        $tmpArray = &$tmpArray[$subKey];
                    } else {
                        $tmpArray = &$tmpArray[$subKey];
                    }
                }
                else {
                    $tmpArray[$subKey] = $value;                    
                    return $this;
                }
            }
        } else {
            $this->properties[$key] = $value;
            return $this;
        }
        
    }

    /**
     * Updates the object's properties with the values in the specified map.
     * @param $map array Map of values to set.
     */
    public function setAll($map) {
        foreach ($map as $key => $value) {
            $this->set($key, $value);
        }
    }
    
    /**
     * Returns the size the of the map
     * @return integer of size
     */
    public function size()
    {
        return sizeof($this->properties);
    }

    /**
     * @ignore
     */
    public function __toString() {
        return json_encode($this->properties);
    }

    /**
     * Returns the object's properties as a map.
     * @return array map of properties.
     */
    public function getProperties() {
        return $this->properties;
    }
}
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
class SmartMap {

    protected $properties = array();
    private $parrentContainsSquaredBracket = '/\[(.*)\]/';

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
                if (empty($tmpArray) || empty($subKey))
                {
                    return null;
                } 
                else if ($index+1 < $keysCount)
                {
                    $tmpArray = $this->getArrayObject($tmpArray, $subKey);
                }
                else {
                    return $this->getArrayObject($tmpArray, $subKey);
                }
            }
        } else {
            return $this->getArrayObject($this->properties, $key);
        }   
        
    }
    
    
    private function getArrayObject($inputArray, $key)
    {
//        echo ">>>getArrayObject(key=$key)\r\n";
        preg_match($this->parrentContainsSquaredBracket, $key, $matches);
        //arizzini: if the curent key contains a square bracket,
        //we are referring to an array
        if (!empty($matches))
        {
            $bracketPosition = strpos($key, "[");
            $listName  = substr($key, 0, $bracketPosition);
            $listIndex = $matches[1] ?: 0;
            
//            echo "listName=$listName \r\n";
//            echo "listIndex=$listIndex \r\n";
            if (array_key_exists($listName, $inputArray)) 
            {
                
                if (array_key_exists($listIndex, $inputArray[$listName]))
                {
//                    echo "--returning list[$listIndex]--\r\n";    
                    return $inputArray[$listName][$listIndex];
                } else {
                    return null;
                }
            } 
            else {
//                echo "--returning NULL--\r\n";
                return null;
            }
        } 
        //arizzini: if the current $index is not the last $subKey
        //we want to the last nested map
        else if (array_key_exists($key, $inputArray)) {
            return $inputArray[$key];
        } else {
            return null;
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
             
                
                if (empty($tmpArray) || empty($subKey))
                {
                    return false;
                } 
                else if ($index+1 < $keysCount)
                {
                    //arizzini: if the current $index is not the last $subKey
                    //we want to check is the $tmpArray is an array
                    $tmpArray = $this->getArrayObject($tmpArray, $subKey);
                }
                else {
//                  echo "checking if subkey=$subKey exists";
//                  print_r($tmpArray);
                    //
                    return $this->getArrayObject($tmpArray, $subKey) !== null;
                    //return array_key_exists($subKey, $tmpArray);
                    
                }
            }
        } else {
            return $this->getArrayObject($this->properties, $key) !== null;
            
        }
        
    }
    
    private function assignArrayByPath(&$arr, $path, $value, $separator='.') {
        $keys = explode($separator, $path);

        foreach ($keys as $key) {
            preg_match($this->parrentContainsSquaredBracket, $key, $matches);
            if (!empty($matches))
            {
                $indexOfSquareBraket = strpos($key, "[");
                $listName  = substr($key, 0, $indexOfSquareBraket);
                $listIndex = $matches[1];
                if (isset($listIndex)) {
                    $arr = &$arr[$listName][$listIndex];
                } else {
                    $arr = &$arr[$listName][];
                }
            } else {
                $arr = &$arr[$key];
            }
        }

        $arr = $value;
    }
    
    /**
     * 
     * @param type $key
     * @param type $value
     * @return \MasterCard\Core\Model\RequestMap
     */
    public function set($key, $value) {
        $this->assignArrayByPath($this->properties, $key, $value);
        return $this;
    }

    /**
     * Updates the object's properties with the values in the specified map.
     * @param $map array Map of values to set.
     */
    public function setAll($map) {
        
        if ($map instanceof SmartMap) {
            $this->properties = array_merge($this->properties, $map->getBaseMapAsArray());
        } else {

            if ($this->isAssoc($map))
            {
                //echo "isAssoc==TRUE\r\n";
                foreach ($map as $key => $value) {
                    $this->set($key, $value);
                }
            } else if (is_array($map)){
                //echo "isAssoc==FALSE\r\n";
                $list = array();
                foreach ($map as $object) {
                    $tmpBaseMap = new SmartMap();
                    $tmpBaseMap->setAll($object);
                    array_push($list, $tmpBaseMap->getBaseMapAsArray());
                }

                $this->set("list", $list);
            }
        }
    }
    
    
    protected function isAssoc($arr)
    {
        return ( array_keys($arr) !== range(0, count($arr) - 1));
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
    public function &getBaseMapAsArray() {
        return $this->properties;
    }
}
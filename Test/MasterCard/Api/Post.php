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

 namespace MasterCard\Api;

 use MasterCard\Core\Model\BaseObject;
 use MasterCard\Core\Model\RequestMap;


/**
 * 
 */
class Post extends BaseObject {

    public static function getResourcePath($action) {
        
        if ($action == "list") {
           return "/mock_crud_server/posts";
        }
        if ($action == "create") {
            return "/mock_crud_server/posts";
        }
        if ($action == "read") {
            return "/mock_crud_server/posts/{id}";
        }
        if ($action == "update") {
            return "/mock_crud_server/posts/{id}";
        }
        if ($action == "delete") {
            return "/mock_crud_server/posts/{id}";
        }
        throw new \Exception("Invalid action supplied: $action");

    }


    public static function getHeaderParams($action) {
        
        if ($action == "list") {
           return array();
        }
        if ($action == "create") {
            return array();
        }
        if ($action == "read") {
            return array();
        }
        if ($action == "update") {
            return array();
        }
        if ($action == "delete") {
            return array();
        }
        throw new \Exception("Invalid action supplied: $action");
    }
    
    
    public static function getQueryParams($action) {
        
        if ($action == "list") {
           return array();
        }
        if ($action == "create") {
            return array();
        }
        if ($action == "read") {
            return array();
        }
        if ($action == "update") {
            return array();
        }
        if ($action == "delete") {
            return array();
        }
        throw new \Exception("Invalid action supplied: $action");
    }


    public static function getApiVersion() {
        return "0.0.1";
    }

   /**
    * List objects of type Post
    *
    * @param Map criteria
    * @return Array of Post object matching the criteria.
    */
    public static function listByCriteria($criteria = null)
    {
        if ($criteria == null) {
            return parent::listObjects(new Post());
        } else {
            return parent::listObjects(new Post($criteria));
        }

    }


   /**
    * Creates object of type Post
    *
    * @param Map map, containing the required parameters to create a new object
    * @return Post of the response of created instance.
    */
    public static function create($map)
    {
        return parent::createObject(new Post($map));
    }








    /**
     * Returns objects of type Post by id and optional criteria
     * @param type $id
     * @param type $criteria
     * @return type
     */
    public static function read($id, $criteria = null)
    {
        $map = new RequestMap();
        $map->set("id", $id);
        return parent::readObject(new Post($map), $criteria);
    }

   /**
    * Updates an object of type Post
    *
    * @return A Post object representing the response.
    */
    public function update()  {
        return parent::updateObject($this);
    }






   /**
    * Delete object of type Post by id
    *
    * @param String id
    * @return Post of the response of the deleted instance.
    */
    public static function deleteById($id)
    {
        $map = new RequestMap();
        $map->set("id", $id);
        $currentObject = new Post($map);
        return $currentObject->deleteObject($currentObject);
    }

   /**
    * Delete this object of type Post
    *
    * @return Post of the response of the deleted instance.
    */
    public function delete()
    {
        return parent::deleteObject($this);
    }



}


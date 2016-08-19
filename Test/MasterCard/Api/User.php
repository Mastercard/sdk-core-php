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
class User extends BaseObject {

    
    protected static function getOperationConfig($operationUUID) {
        switch ($operationUUID) {
            case "list":
                return new OperationConfig("/mock_crud_server/users", "list", array(), array());
            case "create":
                return new OperationConfig("/mock_crud_server/users", "create", array(), array());
            case "read":
                return new OperationConfig("/mock_crud_server/users/{id}", "read", array(), array());
            case "delete":
                return new OperationConfig("/mock_crud_server/users/{id}", "delete", array(), array());
            case "update":
                return new OperationConfig("/mock_crud_server/users/{id}", "update", array(), array());
            default:
                throw new \Exception("Invalid operationUUID supplied: $operationUUID");
        }
    }
    
    protected static function getOperationMetadata() {
        return new OperationMetadata("1.0.0", "http://localhost:8081");
    }


   /**
    * List objects of type User
    *
    * @param Map criteria
    * @return Array of User object matching the criteria.
    */
    public static function listByCriteria($criteria = null)
    {
        if ($criteria == null) {
            return parent::execute("list", new User());
        } else {
            return parent::execute("list", new User($criteria));
        }
    }


   /**
    * Creates object of type User
    *
    * @param Map map, containing the required parameters to create a new object
    * @return User of the response of created instance.
    */
    public static function create($map)
    {
        return parent::execute("create", new User($map));
    }








    /**
     * Returns objects of type User by id and optional criteria
     * @param type $id
     * @param type $criteria
     * @return type
     */
    public static function read($id, $criteria = null)
    {
        $map = new RequestMap();
        $map->set("id", $id);
        if ($criteria != null) {
            $map->setAll($criteria);
        }
        return parent::execute("read", new User($map));
    }

   /**
    * Updates an object of type User
    *
    * @return A User object representing the response.
    */
    public function update()  {
        return parent::execute("update", $this);
    }






   /**
    * Delete object of type User by id
    *
    * @param String id
    * @return User of the response of the deleted instance.
    */
    public static function deleteById($id)
    {
        $map = new RequestMap();
        $map->set("id", $id);
        return self::execute("delete", new User($map));
    }

   /**
    * Delete this object of type User
    *
    * @return User of the response of the deleted instance.
    */
    public function delete()
    {
        return self::execute("delete", $this);
    }



}


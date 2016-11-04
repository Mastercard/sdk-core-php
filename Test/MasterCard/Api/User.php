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
 use MasterCard\Core\Model\OperationMetadata;
 use MasterCard\Core\Model\OperationConfig;


/**
 * 
 */
class User extends BaseObject {


    protected static function getOperationConfig($operationUUID) {
        switch ($operationUUID) {
            case "f7f76a1b-3e99-443e-bf4e-bcc497dbe32d":
                return new OperationConfig("/mock_crud_server/users", "list", array(), array());
            case "04b1ca2b-3631-4dae-9b7e-868ec6352033":
                return new OperationConfig("/mock_crud_server/users", "create", array(), array());
            case "081760b1-928c-44f6-943d-fb904b0ab0c4":
                return new OperationConfig("/mock_crud_server/users/{id}", "read", array(), array());
            case "2669cecc-3107-4ecb-8327-2411d1ae2a97":
                return new OperationConfig("/mock_crud_server/users/{id}", "update", array(), array());
            case "09db9343-eaf4-403f-a449-a11124ffb223":
                return new OperationConfig("/mock_crud_server/users/{id}", "delete", array(), array());
            case "04b8baa4-e27c-45e5-aa17-e47130a7f720":
                return new OperationConfig("/mock_crud_server/users200/{id}", "delete", array(), array());
            case "547493bc-e096-4b4c-9e33-2534c7a95aae":
                return new OperationConfig("/mock_crud_server/users204/{id}", "delete", array(), array());
            
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
            return self::execute("f7f76a1b-3e99-443e-bf4e-bcc497dbe32d",new User());
        } else {
            return self::execute("f7f76a1b-3e99-443e-bf4e-bcc497dbe32d",new User($criteria));
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
        return self::execute("04b1ca2b-3631-4dae-9b7e-868ec6352033", new User($map));
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
        if (!empty($id)) {
            $map->set("id", $id);
        }
        if ($criteria != null) {
            $map->setAll($criteria);
        }
        return self::execute("081760b1-928c-44f6-943d-fb904b0ab0c4",new User($map));
    }


   /**
    * Updates an object of type User
    *
    * @return A User object representing the response.
    */
    public function update()  {
        return self::execute("2669cecc-3107-4ecb-8327-2411d1ae2a97",$this);
    }







   /**
    * Delete object of type User by id
    *
    * @param String id
    * @return User of the response of the deleted instance.
    */
    public static function deleteById($id, $requestMap = null)
    {
        $map = new RequestMap();
        if (!empty($id)) {
            $map->set("id", $id);
        }
        if (!empty($requestMap)) {
            $map->setAll($requestMap);
        }
        return self::execute("09db9343-eaf4-403f-a449-a11124ffb223", new User($map));
    }

   /**
    * Delete this object of type User
    *
    * @return User of the response of the deleted instance.
    */
    public function delete()
    {
        return self::execute("09db9343-eaf4-403f-a449-a11124ffb223", $this);
    }





   /**
    * Delete object of type User by id
    *
    * @param String id
    * @return User of the response of the deleted instance.
    */
    public static function delete200ById($id, $requestMap = null)
    {
        $map = new RequestMap();
        if (!empty($id)) {
            $map->set("id", $id);
        }
        if (!empty($requestMap)) {
            $map->setAll($requestMap);
        }
        return self::execute("04b8baa4-e27c-45e5-aa17-e47130a7f720", new User($map));
    }

   /**
    * Delete this object of type User
    *
    * @return User of the response of the deleted instance.
    */
    public function delete200()
    {
        return self::execute("04b8baa4-e27c-45e5-aa17-e47130a7f720", $this);
    }





   /**
    * Delete object of type User by id
    *
    * @param String id
    * @return User of the response of the deleted instance.
    */
    public static function delete204ById($id, $requestMap = null)
    {
        $map = new RequestMap();
        if (!empty($id)) {
            $map->set("id", $id);
        }
        if (!empty($requestMap)) {
            $map->setAll($requestMap);
        }
        return self::execute("547493bc-e096-4b4c-9e33-2534c7a95aae", new User($map));
    }

   /**
    * Delete this object of type User
    *
    * @return User of the response of the deleted instance.
    */
    public function delete204()
    {
        return self::execute("547493bc-e096-4b4c-9e33-2534c7a95aae", $this);
    }




}


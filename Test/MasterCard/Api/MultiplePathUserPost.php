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
class MultiplePathUserPost extends BaseObject {


    protected static function getOperationConfig($operationUUID) {
        switch ($operationUUID) {
            case "57d7e431-4edb-4cc4-b21a-75eb8c5ecd8d":
                return new OperationConfig("/mock_crud_server/users/{user_id}/post/{post_id}", "list", array(), array());
            case "a6fd8826-a957-4975-b977-388064bd5f8c":
                return new OperationConfig("/mock_crud_server/users/{user_id}/post/{post_id}", "update", array("testQuery"), array());
            case "40e28221-901f-4a39-a23c-80c677d63908":
                return new OperationConfig("/mock_crud_server/users/{user_id}/post/{post_id}", "delete", array(), array());
            
            default:
                throw new \Exception("Invalid operationUUID supplied: $operationUUID");
        }
    }

    protected static function getOperationMetadata() {
        return new OperationMetadata("1.0.0", "http://localhost:8081");

    }




   /**
    * List objects of type MultiplePathUserPost
    *
    * @param Map criteria
    * @return Array of MultiplePathUserPost object matching the criteria.
    */
    public static function listByCriteria($criteria = null)
    {
        if ($criteria == null) {
            return self::execute("57d7e431-4edb-4cc4-b21a-75eb8c5ecd8d",new MultiplePathUserPost());
        } else {
            return self::execute("57d7e431-4edb-4cc4-b21a-75eb8c5ecd8d",new MultiplePathUserPost($criteria));
        }

    }




   /**
    * Updates an object of type MultiplePathUserPost
    *
    * @return A MultiplePathUserPost object representing the response.
    */
    public function update()  {
        return self::execute("a6fd8826-a957-4975-b977-388064bd5f8c",$this);
    }







   /**
    * Delete object of type MultiplePathUserPost by id
    *
    * @param String id
    * @return MultiplePathUserPost of the response of the deleted instance.
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
        return self::execute("40e28221-901f-4a39-a23c-80c677d63908", new MultiplePathUserPost($map));
    }

   /**
    * Delete this object of type MultiplePathUserPost
    *
    * @return MultiplePathUserPost of the response of the deleted instance.
    */
    public function delete()
    {
        return self::execute("40e28221-901f-4a39-a23c-80c677d63908", $this);
    }




}


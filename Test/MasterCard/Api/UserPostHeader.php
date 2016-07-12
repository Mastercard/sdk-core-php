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
 use MasterCard\Core\Model\BaseMap;


/**
 * 
 */
class UserPostHeader extends BaseObject {

    public static function getResourcePath($action) {
        
        if ($action == "list") {
           return "/mock_crud_server/users/posts";
        }
        throw new \Exception("Invalid action supplied: $action");

    }


    public static function getHeaderParams($action) {
        
        if ($action == "list") {
           return array("user_id");
        }
        throw new \Exception("Invalid action supplied: $action");
    }
    
    public static function getQueryParams($action) {
        
        if ($action == "list") {
           return array("user_id");
        }
        throw new \Exception("Invalid action supplied: $action");
    }
    
    public static function getApiVersion() {
        return "0.0.1";
    }



   /**
    * List objects of type UserPostHeader
    *
    * @param Map criteria
    * @return Array of UserPostHeader object matching the criteria.
    */
    public static function listByCriteria($criteria = null)
    {
        if ($criteria == null) {
            return parent::listObjects(new UserPostHeader());
        } else {
            return parent::listObjects(new UserPostHeader($criteria));
        }

    }
    




}


<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MasterCard\Api;

use \MasterCard\Core\Model\BaseObject;

class AccountEnquiry extends  BaseObject{
    const BasePath = "/fraud/loststolen/v1";
    const ObjectType = "account-inquiry";
    
    /**
     * getBasePath
     * @return String
     */
    public function getBasePath() {
        return self::BasePath;
    }
    
    /**
     * getObjectType
     * @return String
     */
    public function getObjectType() {
        return self::ObjectType;
    }
    
    /**
     * Updates the object
     * @return AccountEnquiry object
     */
    public function update()
    {
        return parent::updateObject($this);
    }
}
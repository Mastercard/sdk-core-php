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
    
    public function getBasePath() {
        return self::BasePath;
    }
    
    public function getObjectType() {
        return self::ObjectType;
    }
    
    public function update()
    {
        return parent::updateObject($this);
    }
}
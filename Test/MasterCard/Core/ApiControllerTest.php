<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MasterCard\Core;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Client;

use MasterCard\Core\Model\BaseMap;
use MasterCard\Core\Model\BaseObject;
use MasterCard\Core\Security\AuthenticationInterface;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;

class ApiControllerTest extends \PHPUnit_Framework_TestCase {
    
    
    protected function setUp() {
        $privateKey = file_get_contents(getcwd()."/prod_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("gVaoFbo86jmTfOB4NUyGKaAchVEU8ZVPalHQRLTxeaf750b6!414b543630362f426b4f6636415a5973656c33735661383d", $privateKey, "alias", "password"));
    }
    
    public static function mockClient($responseStatusCode, $requesponseAsJson) {
        $mock = new MockHandler([
            new Response($responseStatusCode, [], $requesponseAsJson)
        ]);
        
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        return $client;
    }
    
    
    
    public function test200WithMap() {
        
        $body = "{ \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" }";
        $requestMap = new BaseMap(json_decode($body, true));
        
        $controller = new ApiController();
        $controller->setClient(self::mockClient(200, $body));
        
        $responseArray = $controller->execute("create", TestBaseObject::getResourcePath("create"), TestBaseObject::getHeaderParams("create"), new TestBaseObject($requestMap));
        
        $this->assertNotEmpty($responseArray);
        
        $responseMap = new BaseMap();
        $responseMap->setAll($responseArray);
        
        $this->assertEquals("andrea", $responseMap->get("user.name"));
        $this->assertEquals("rizzini", $responseMap->get("user.surname"));
    }
    
    
    public function test200WithList() {
        
        $body = "[ { \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" } ]";
        $requestMap = new BaseMap(json_decode($body, true));
        
        $controller = new ApiController();
        $controller->setClient(self::mockClient(200, $body));
        
        $responseArray = $controller->execute("create", TestBaseObject::getResourcePath("create"),  TestBaseObject::getHeaderParams("create"),new TestBaseObject($requestMap));
        
        $this->assertNotEmpty($responseArray);
        
        $responseMap = new BaseMap();
        $responseMap->setAll($responseArray);
        
        $this->assertEquals("andrea", $responseMap->get("list[0].user.name"));
        $this->assertEquals("rizzini", $responseMap->get("list[0].user.surname"));
    }
    
    
    public function test204()
    {
        $body = "{ \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" }";
        $requestMap = new BaseMap(json_decode($body, true));
        
        $controller = new ApiController();
        $controller->setClient(self::mockClient(204, ""));
        
        $responseArray = $controller->execute("create", TestBaseObject::getResourcePath("create"), TestBaseObject::getHeaderParams("create"),new TestBaseObject($requestMap));
        
        $this->assertEmpty($responseArray);
        
    }
    
    
    public function test405_not_allowed()
    {
        $this->expectException(Exception\NotAllowedException::class);
        
        $body = "{\"Errors\":{\"Error\":{\"Source\":\"System\",\"ReasonCode\":\"METHOD_NOT_ALLOWED\",\"Description\":\"Method not Allowed\",\"Recoverable\":\"false\"}}}";
        $requestMap = new BaseMap(json_decode($body, true));
                
        $controller = new ApiController();
        $controller->setClient(self::mockClient(405, $body));
        
        $controller->execute( "create", TestBaseObject::getResourcePath("create"), TestBaseObject::getHeaderParams("create"), new TestBaseObject($requestMap));
    }
    
    
    public function test400_invald_request()
    {
        $this->expectException(Exception\InvalidRequestException::class);
        
        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"Validation\",\"ReasonCode\":\"INVALID_TYPE\",\"Description\":\"The supplied field: 'date' is of an unsupported format\",\"Recoverable\":false,\"Details\":null}]}}\n";
        $requestMap = new BaseMap(json_decode($body, true));
                
        $controller = new ApiController();
        $controller->setClient(self::mockClient(400, $body));
        
        $controller->execute("create", TestBaseObject::getResourcePath("create"),  TestBaseObject::getHeaderParams("create"), new TestBaseObject($requestMap));
    }
    
    
    public function test401_unauthorised()
    {
        $this->expectException(Exception\AuthenticationException::class);
        
        $body = "{\"Errors\":{\"Error\":{\"Source\":\"Authentication\",\"ReasonCode\":\"FAILED\",\"Description\":\"OAuth signature is not valid\",\"Recoverable\":\"false\"}}}";
        $requestMap = new BaseMap(json_decode($body, true));
                
        $controller = new ApiController();
        $controller->setClient(self::mockClient(401, $body));
        
        $controller->execute( "create", TestBaseObject::getResourcePath("create"), TestBaseObject::getHeaderParams("create"), new TestBaseObject($requestMap));
    }
    
    
    public function test500_invalidrequest()
    {
        $this->expectException(Exception\SystemException::class);
        
        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"OAuth.ConsumerKey\",\"ReasonCode\":\"INVALID_CLIENT_ID\",\"Description\":\"Something went wrong\",\"Recoverable\":false,\"Details\":null}]}}";
        $requestMap = new BaseMap(json_decode($body, true));
                
        $controller = new ApiController();
        $controller->setClient(self::mockClient(500, $body));
        
        $controller->execute( "create", TestBaseObject::getResourcePath("create"), TestBaseObject::getHeaderParams("create"), new TestBaseObject($requestMap));
    }
    
    
    public function testGetUrl()
    {
        $controller = new ApiController();
        
        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $url = $controller->getUrl("create", "/fraud/{api}/v{version}/account-inquiry", $inputMap);
        
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?Format=JSON", $url);
        $this->assertEquals(3, count($inputMap));
        
    }

    
}


class TestBaseObject extends BaseObject
{
    /**
     * getObjectType
     * @return String
     */
    public static function getResourcePath($action) {
        return "/testurl/test-base-object";
    }
    
    public static function getHeaderParams($action) {
        return array();
    }
}


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
use MasterCard\Core\Model\RequestMap;
use MasterCard\Core\Model\BaseObject;
use MasterCard\Core\Model\OperationConfig;
use MasterCard\Core\Model\OperationMetadata;
use MasterCard\Core\Security\AuthenticationInterface;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;

class ApiControllerTest extends \PHPUnit_Framework_TestCase {

    protected function setUp() {
        $privateKey = file_get_contents(getcwd() . "/mcapi_sandbox_key.p12");
        ApiConfig::setAuthentication(new OAuthAuthentication("L5BsiPgaF-O3qA36znUATgQXwJB6MRoMSdhjd7wt50c97279!50596e52466e3966546d434b7354584c4975693238513d3d", $privateKey, "test", "password"));
    }

    public static function mockClient($responseStatusCode, $requesponseAsJson) {
        $mock = new MockHandler([
            new Response($responseStatusCode, [], $requesponseAsJson)
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        return $client;
    }

    public function testApiConfig() {

        //test default      
        $this->assertEquals("sandbox", ApiConfig::getSubDomain());
        $this->assertEquals(null, ApiConfig::getEnvironment());

        ApiConfig::setSandbox(true);
        $this->assertEquals("sandbox", ApiConfig::getSubDomain());
        $this->assertEquals(null, ApiConfig::getEnvironment());

        ApiConfig::setSandbox(false);
        $this->assertEquals(null, ApiConfig::getSubDomain());
        $this->assertEquals(null, ApiConfig::getEnvironment());

        ApiConfig::setSubDomain("stage");
        ApiConfig::setEnvironment("mtf");

        $this->assertEquals("stage", ApiConfig::getSubDomain());
        $this->assertEquals("mtf", ApiConfig::getEnvironment());

        ApiConfig::setSubDomain("");
        ApiConfig::setEnvironment("");

        $this->assertEquals(null, ApiConfig::getSubDomain());
        $this->assertEquals(null, ApiConfig::getEnvironment());
        
        //resetting the config
        ApiConfig::setSubDomain("sandbox");
        ApiConfig::setEnvironment("");
    }
    
    public function testHost() {
        
        $apiController = new ApiController("0.0.1");
        $this->assertEquals("https://sandbox.api.mastercard.com/", $apiController->getHostUrl());
        
        ApiConfig::setSubDomain("stage");
        $apiController = new ApiController("0.0.1");
        $this->assertEquals("https://stage.api.mastercard.com/", $apiController->getHostUrl());
        
        ApiConfig::setSubDomain("dev");
        $apiController = new ApiController("0.0.1");
        $this->assertEquals("https://dev.api.mastercard.com/", $apiController->getHostUrl());
        
        ApiConfig::setSubDomain("");
        $apiController = new ApiController("0.0.1");
        $this->assertEquals("https://api.mastercard.com/", $apiController->getHostUrl());
        
        //resetting the config
        ApiConfig::setSubDomain("sandbox");
        ApiConfig::setEnvironment("");
    }
    
    
    public function testEnvironment() {
        $controller = new ApiController("0.0.1");

        $inputMap = array();
        $operationMetadate = new OperationMetadata("0.0.1", null);
        $operationConfig = new OperationConfig("/{:env}/fraud/v1/account-inquiry", "create", array(), array());
        
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment("itf");
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/itf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment("mtf");
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/mtf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment("peat");
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/peat/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment(null);
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment("");
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/v1/account-inquiry?Format=JSON", $url);
    }


    public function test200WithMap() {

        $body = "{ \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" }";
        $requestMap = new RequestMap(json_decode($body, true));


        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(200, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());

        $this->assertNotEmpty($responseArray);

        $responseMap = new RequestMap();
        $responseMap->setAll($responseArray);

        $this->assertEquals("andrea", $responseMap->get("user.name"));
        $this->assertEquals("rizzini", $responseMap->get("user.surname"));
    }

    public function test200WithList() {

        $body = "[ { \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" } ]";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(200, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());

        $this->assertNotEmpty($responseArray);

        $responseMap = new RequestMap();
        $responseMap->setAll($responseArray);

        $this->assertEquals("andrea", $responseMap->get("list[0].user.name"));
        $this->assertEquals("rizzini", $responseMap->get("list[0].user.surname"));
    }

    public function test204() {
        $body = "{ \"user.name\":\"andrea\", \"user.surname\":\"rizzini\" }";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(204, ""));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());

        $this->assertEmpty($responseArray);
    }

    public function test405_not_allowed() {
        $this->expectException(Exception\NotAllowedException::class);

        $body = "{\"Errors\":{\"Error\":{\"Source\":\"System\",\"ReasonCode\":\"METHOD_NOT_ALLOWED\",\"Description\":\"Method not Allowed\",\"Recoverable\":\"false\"}}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(405, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
    }

    public function test400_invald_request() {
        $this->expectException(Exception\InvalidRequestException::class);

        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"Validation\",\"ReasonCode\":\"INVALID_TYPE\",\"Description\":\"The supplied field: 'date' is of an unsupported format\",\"Recoverable\":false,\"Details\":null}]}}\n";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(400, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
    }

    public function test401_unauthorised() {
        $this->expectException(Exception\AuthenticationException::class);

        $body = "{\"Errors\":{\"Error\":{\"Source\":\"Authentication\",\"ReasonCode\":\"FAILED\",\"Description\":\"OAuth signature is not valid\",\"Recoverable\":\"false\"}}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(401, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
    }

    public function test500_invalidrequest() {
        $this->expectException(Exception\SystemException::class);

        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"OAuth.ConsumerKey\",\"ReasonCode\":\"INVALID_CLIENT_ID\",\"Description\":\"Something went wrong\",\"Recoverable\":false,\"Details\":null}]}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
    }

    public function testGetUrlWithEmptyQueue() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );



        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array(), array());
        $operationMetadate = new OperationMetadata("0.0.1", null);

        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?Format=JSON", $url);
        $this->assertEquals(3, count($inputMap));
    }

    public function testGetUrlWithNonMatchingQueue() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );

        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('six', 'seven', 'eight'), array());
        $operationMetadate = new OperationMetadata("0.0.1", null);
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?Format=JSON", $url);
        $this->assertEquals(3, count($inputMap));
    }

    public function testGetUrlWithQuery() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );

        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $operationMetadate = new OperationMetadata("0.0.1", null);
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?three=3&Format=JSON", $url);
        $this->assertEquals(2, count($inputMap));
    }

    public function testGetUrlWithHostOverride() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );


        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $operationMetadate = new OperationMetadata("0.0.1", "http://localhost:8081");
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("http://localhost:8081/fraud/lostandstolen/v1/account-inquiry?three=3&Format=JSON", $url);
        $this->assertEquals(2, count($inputMap));
    }

}

class TestBaseObject extends BaseObject {

    /**
     * getObjectType
     * @return String
     */
    public static function getOperationMetadata() {
        return new OperationMetadata("1.0.0", null);
    }

    public static function getOperationConfig($operationUUID) {
        return new OperationConfig("/testurl/test-base-object", "update", array(), array());
    }

}

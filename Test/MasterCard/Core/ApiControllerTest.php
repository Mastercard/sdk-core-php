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
use MasterCard\Api\ResourceConfig;
use MasterCard\Core\Model\Environment;
use MasterCard\Core\Model\RequestMap;
use MasterCard\Core\Model\BaseObject;
use MasterCard\Core\Model\OperationConfig;
use MasterCard\Core\Model\OperationMetadata;
use MasterCard\Core\Security\AuthenticationInterface;
use MasterCard\Core\Security\OAuth\OAuthAuthentication;
use PHPUnit\Framework\TestCase;

class ApiControllerTest extends TestCase {

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
        
        $this->assertEquals(Environment::SANDBOX, ApiConfig::getEnvironment());

        ApiConfig::setSandbox(true);
        $this->assertEquals(Environment::SANDBOX, ApiConfig::getEnvironment());

        ApiConfig::setSandbox(false);
        $this->assertEquals(Environment::PRODUCTION, ApiConfig::getEnvironment());

    }
    
    
    public function testEnvironment() {
        $controller = new ApiController("0.0.1");

        $inputMap = array();
        $config = ResourceConfig::getInstance();
        ApiConfig::registerResourceConfig($config);
        

        ApiConfig::setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/v1/account-inquiry?Format=JSON", $url);
        
        //arizzini: testing isJsonNative = true
        ApiConfig::setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext(), true);
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/v1/account-inquiry", $url);
        
        ApiConfig::setEnvironment(Environment::PRODUCTION_ITF);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://api.mastercard.com/itf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment(Environment::PRODUCTION_MTF);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://api.mastercard.com/mtf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment(null);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://api.mastercard.com/mtf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::setEnvironment("");
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://api.mastercard.com/mtf/fraud/v1/account-inquiry?Format=JSON", $url);
        
        
        ApiConfig::setEnvironment(Environment::PRODUCTION);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/#env/fraud/v1/account-inquiry", "create", array(), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);
        $this->assertEquals("https://api.mastercard.com/fraud/v1/account-inquiry?Format=JSON", $url);
        
        ApiConfig::clearResourceConfig();
        ApiConfig::setEnvironment(Environment::SANDBOX);
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
        $this->expectException(Exception\ApiException::class);
        

        $body = "{\"Errors\":{\"Error\":{\"Source\":\"System\",\"ReasonCode\":\"METHOD_NOT_ALLOWED\",\"Description\":\"Method not Allowed\",\"Recoverable\":\"false\"}}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(405, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Method not Allowed", $ex->getMessage());
            $this->assertEquals("System", $ex->getSource());
            $this->assertEquals("METHOD_NOT_ALLOWED", $ex->getReasonCode());
            throw $ex;
        }
        
    }
    
    
        public function test405_not_allowed_case_insensitive() {
        $this->expectException(Exception\ApiException::class);
        

        $body = "{\"errors\":{\"error\":{\"source\":\"System\",\"reasonCode\":\"METHOD_NOT_ALLOWED\",\"description\":\"Method not Allowed\",\"recoverable\":\"false\"}}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(405, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Method not Allowed", $ex->getMessage());
            $this->assertEquals("System", $ex->getSource());
            $this->assertEquals("METHOD_NOT_ALLOWED", $ex->getReasonCode());
            throw $ex;
        }
        
    }

    public function test400_invald_request() {
        $this->expectException(Exception\ApiException::class);

        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"Validation\",\"ReasonCode\":\"INVALID_TYPE\",\"Description\":\"The supplied field: 'date' is of an unsupported format\",\"Recoverable\":false,\"Details\":null}]}}\n";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(400, $body));

        $testObject = new TestBaseObject($requestMap);
        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("The supplied field: 'date' is of an unsupported format", $ex->getMessage());
            $this->assertEquals("Validation", $ex->getSource());
            $this->assertEquals("INVALID_TYPE", $ex->getReasonCode());
            throw $ex;
        }
    }
    
    public function test400_invald_request_case_insensitive() {
        $this->expectException(Exception\ApiException::class);

        $body = "{\"errors\":{\"error\":[{\"source\":\"Validation\",\"reasonCode\":\"INVALID_TYPE\",\"description\":\"The supplied field: 'date' is of an unsupported format\",\"recoverable\":false,\"details\":null}]}}\n";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(400, $body));

        $testObject = new TestBaseObject($requestMap);
        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("The supplied field: 'date' is of an unsupported format", $ex->getMessage());
            $this->assertEquals("Validation", $ex->getSource());
            $this->assertEquals("INVALID_TYPE", $ex->getReasonCode());
            throw $ex;
        }
    }
    

    public function test401_unauthorised() {
        $this->expectException(Exception\ApiException::class);

        $body = "{\"Errors\":{\"Error\":{\"Source\":\"Authentication\",\"ReasonCode\":\"FAILED\",\"Description\":\"OAuth signature is not valid\",\"Recoverable\":\"false\"}}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(401, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("OAuth signature is not valid", $ex->getMessage());
            $this->assertEquals("Authentication", $ex->getSource());
            $this->assertEquals("FAILED", $ex->getReasonCode());
            throw $ex;
        }
    }

    public function test500_invalidrequest() {
        $this->expectException(Exception\ApiException::class);

        $body = "{\"Errors\":{\"Error\":[{\"Source\":\"OAuth.ConsumerKey\",\"ReasonCode\":\"INVALID_CLIENT_ID\",\"Description\":\"Something went wrong\",\"Recoverable\":false,\"Details\":null}]}}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Something went wrong", $ex->getMessage());
            $this->assertEquals("OAuth.ConsumerKey", $ex->getSource());
            $this->assertEquals("INVALID_CLIENT_ID", $ex->getReasonCode());
            $this->assertEquals("OAuth.ConsumerKey", $ex->getRawErrorData()->get("Errors.Error[0].Source"));
            throw $ex;
        }
    }
    
    public function test500_invalidrequest_array() {
        $this->expectException(Exception\ApiException::class);

        $body = "{\"Errors\":[{\"Source\":\"OAuth.ConsumerKey\",\"ReasonCode\":\"INVALID_CLIENT_ID\",\"Description\":\"Something went wrong\",\"Recoverable\":false,\"Details\":null}]}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Something went wrong", $ex->getMessage());
            $this->assertEquals("OAuth.ConsumerKey", $ex->getSource());
            $this->assertEquals("INVALID_CLIENT_ID", $ex->getReasonCode());
            $this->assertEquals("OAuth.ConsumerKey", $ex->getRawErrorData()->get("Errors[0].Source"));
            throw $ex;
        }
    }
    
    
    
    public function test500_invalidrequest_json_native() {
        $this->expectException(Exception\ApiException::class);
    
    //
        $body = "{\"errors\":[{\"source\":\"OpenAPIClientId\",\"reasonCode\":\"AUTHORIZATION_FAILED\",\"key\":\"050007\",\"description\":\"Unauthorized Access\",\"recoverable\":false,\"requestId\":null,\"details\":{\"details\":[{\"name\":\"ErrorDetailCode\",\"value\":\"050007\"}]}}]}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Unauthorized Access", $ex->getMessage());
            $this->assertEquals("OpenAPIClientId", $ex->getSource());
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getReasonCode());
            $this->assertEquals("OpenAPIClientId", $ex->getRawErrorData()->get("errors[0].source"));
            throw $ex;
        }
    }
    
    
    public function test500_invalidrequest_json_native2() {
        $this->expectException(Exception\ApiException::class);
    
    //
        $body = "{\"errors\":[{\"source\":\"OpenAPIClientId\",\"reasonCode\":\"AUTHORIZATION_FAILED\",\"key\":\"050007\",\"description\":\"Unauthorized Access\"},{\"source\":\"OpenAPIClientId\",\"reasonCode\":\"AUTHORIZATION_FAILED\",\"key\":\"050008\",\"description\":\"Unauthorized Access\"}]}";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Unauthorized Access", $ex->getMessage());
            $this->assertEquals("OpenAPIClientId", $ex->getSource());
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getReasonCode());
            $this->assertEquals("050007", $ex->getError()->get("key"));
            $this->assertEquals("OpenAPIClientId", $ex->getRawErrorData()->get("errors[0].source"));
            
            $this->assertEquals(2, $ex->getErrorSize());
            $ex->parseError(1);
            
            $this->assertEquals("Unauthorized Access", $ex->getMessage());
            $this->assertEquals("OpenAPIClientId", $ex->getSource());
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getReasonCode());
            $this->assertEquals("050008", $ex->getError()->get("key"));
                    
            throw $ex;
        }
    }
    
    public function test500_invalidrequest_json_native3() {
        $this->expectException(Exception\ApiException::class);
    
    //
        $body = "[{\"source\":\"OpenAPIClientId\",\"reasonCode\":\"AUTHORIZATION_FAILED\",\"key\":\"050007\",\"description\":\"Unauthorized Access\"},{\"source\":\"OpenAPIClientId\",\"reasonCode\":\"AUTHORIZATION_FAILED\",\"key\":\"050008\",\"description\":\"Unauthorized Access\"}]";
        $requestMap = new RequestMap(json_decode($body, true));

        $controller = new ApiController("0.0.1");
        $controller->setClient(self::mockClient(500, $body));

        $testObject = new TestBaseObject($requestMap);

        try {
            $responseArray = $controller->execute($testObject->getOperationConfig("uuid"), $testObject->getOperationMetadata(), $testObject->getBaseMapAsArray());
        } catch (Exception\ApiException $ex) {
            $this->assertEquals("Unauthorized Access", $ex->getMessage());
            $this->assertEquals("OpenAPIClientId", $ex->getSource());
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getReasonCode());
            $this->assertEquals("050007", $ex->getError()->get("key"));
            $this->assertEquals("OpenAPIClientId", $ex->getRawErrorData()->get("source"));
            
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getRawErrorData()->get("reasonCode"));
            
            $this->assertEquals(2, $ex->getErrorSize());
            $ex->parseError(1);
            
            $this->assertEquals("Unauthorized Access", $ex->getMessage());
            $this->assertEquals("OpenAPIClientId", $ex->getSource());
            $this->assertEquals("AUTHORIZATION_FAILED", $ex->getReasonCode());
            $this->assertEquals("050008", $ex->getError()->get("key"));
                    
            throw $ex;
        }
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


        $config = ResourceConfig::getInstance();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());
        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array(), array());
        

        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?Format=JSON", $url);
        $this->assertCount(3, $inputMap);
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

        $config = ResourceConfig::getInstance();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());

        
        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('six', 'seven', 'eight'), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?Format=JSON", $url);
        $this->assertCount(3, $inputMap);
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
        
        $config = ResourceConfig::getInstance();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());



        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("https://sandbox.api.mastercard.com/fraud/lostandstolen/v1/account-inquiry?three=3&Format=JSON", $url);
        $this->assertCount(2, $inputMap);
    }
    
    public function testGetUrlWithOverride() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $config = ResourceConfig::getInstance();
        $config->setOverride();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("0.0.1", $config->getHost(), $config->getContext());


        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $url = $controller->getUrl($operationConfig, $operationMetadate, $inputMap);

        $this->assertEquals("http://localhost:8081/fraud/lostandstolen/v1/account-inquiry?three=3&Format=JSON", $url);
        $this->assertCount(2, $inputMap);
    }
    
    public function test_POST_request() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $config = ResourceConfig::getInstance();
        $config->setOverride();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("mock:0.0.1", $config->getHost(), $config->getContext());


        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $request = $controller->getRequest($operationConfig, $operationMetadate, $inputMap);
        

        $this->assertEquals("POST", $request->getMethod());
        $this->assertEquals(json_encode(array('four' => 4, 'five' => 5)), $request->getBody());
        
        $headers = $request->getHeaders();
        
        //arizzini: Content-Type is present
        $this->assertArrayHasKey("Content-Type", $headers);
        
        //arizzini: Accept is present
        $this->assertArrayHasKey("Accept", $headers);
        
        $this->assertEquals("mastercard-api-core(php):1.4.7/mock:0.0.1", $headers['User-Agent'][0]);
        
        //arizzini: oauth_body_hash is present in OAUTH token.
        $this->assertContains('oauth_body_hash', $headers['Authorization'][0]);
        
    }
    
        public function test_POST_request_with_jsonNative_and_contentTypeOverride() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $config = ResourceConfig::getInstance();
        $config->setOverride();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("mock:0.0.1", $config->getHost(), $config->getContext(), true, "text/json");


        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "create", array('one', 'two', 'three'), array());
        $request = $controller->getRequest($operationConfig, $operationMetadate, $inputMap);
        

        $this->assertEquals("POST", $request->getMethod());
        $this->assertEquals(json_encode(array('four' => 4, 'five' => 5)), $request->getBody());
        
        $headers = $request->getHeaders();
        
        //arizzini: Content-Type is present
        $this->assertArrayHasKey("Content-Type", $headers);
        $this->assertEquals("text/json; charset=utf-8", $headers['Content-Type'][0]);
        //arizzini: Accept is present
        $this->assertArrayHasKey("Accept", $headers);
        $this->assertEquals("text/json; charset=utf-8", $headers['Accept'][0]);
        
        $this->assertEquals("mastercard-api-core(php):1.4.7/mock:0.0.1", $headers['User-Agent'][0]);
        
        //arizzini: oauth_body_hash is present in OAUTH token.
        $this->assertContains('oauth_body_hash', $headers['Authorization'][0]);
        
    }
    
    
     public function test_GET_request() {
        $controller = new ApiController("0.0.1");

        $inputMap = array(
            'api' => 'lostandstolen',
            'version' => 1,
            'three' => 3,
            'four' => 4,
            'five' => 5
        );
        
        $config = ResourceConfig::getInstance();
        $config->setOverride();
        $config->setEnvironment(Environment::SANDBOX);
        $operationMetadate = new OperationMetadata("mock:0.0.1", $config->getHost(), $config->getContext());


        $operationConfig = new OperationConfig("/fraud/{api}/v{version}/account-inquiry", "query", array('one', 'two', 'three'), array());
        $request = $controller->getRequest($operationConfig, $operationMetadate, $inputMap);
        

        
        $this->assertEquals("GET", $request->getMethod());
        $body = $request->getBody()->getContents();
        $this->assertEmpty($body);
        
        $headers = $request->getHeaders();
        
        //arizzini: Content-Type is not present
        $this->assertArrayNotHasKey("Content-Type", $headers);
        
        //arizzini: Accept is present
        $this->assertArrayHasKey("Accept", $headers);
        
        $this->assertEquals("mastercard-api-core(php):1.4.7/mock:0.0.1", $headers['User-Agent'][0]);
        
        //arizzini: oauth_body_hash is not present
        $this->assertNotContains('oauth_body_hash', $headers['Authorization'][0]);
        
    }
    


}

class TestBaseObject extends BaseObject {

    /**
     * getObjectType
     * @return String
     */
    public static function getOperationMetadata() {
        return new OperationMetadata("1.0.0", "http://localhost:8081");
    }

    public static function getOperationConfig($operationUUID) {
        return new OperationConfig("/testurl/test-base-object", "update", array(), array());
    }

}

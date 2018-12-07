<?php

namespace rdoepner\CleverReach\Tests\Http;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use rdoepner\CleverReach\ApiManager;
use rdoepner\CleverReach\Http\Guzzle as HttpAdapter;

class ApiTest extends TestCase
{
    /**
     * @var HttpAdapter
     */
    protected static $httpAdapter;

    /**
     * @var ApiManager
     */
    protected static $apiManager;

    public static function setUpBeforeClass()
    {
        self::$httpAdapter = new HttpAdapter(
            [
                'access_token' => 'ACCESS_TOKEN',
            ],
            (new Logger('debug'))->pushHandler(
                new StreamHandler(__DIR__.'/../var/log/api.log')
            )
        );

        self::$apiManager = new ApiManager(self::$httpAdapter);
    }

    public function testConfig()
    {
        $this->assertArrayHasKey('access_token', self::$httpAdapter->getConfig());
        $this->assertEquals('ACCESS_TOKEN', self::$httpAdapter->getConfig('access_token'));
        $this->assertArrayHasKey('base_uri', self::$httpAdapter->getConfig('adapter_config'));
        $this->assertEquals('https://rest.cleverreach.com', self::$httpAdapter->getConfig('base_uri'));
    }

    public function testAuthorize()
    {
        $response = self::$httpAdapter->authorize(
            getenv('CLIENT_ID'),
            getenv('CLIENT_SECRET')
        );

        $this->assertArrayHasKey('access_token', $response);
    }

    public function testGetAccessToken()
    {
        $this->assertNotEquals('ACCESS_TOKEN', self::$httpAdapter->getAccessToken());
    }

    public function testCreateSubscriber()
    {
        $response = self::$apiManager->createSubscriber(
            'john.doe@example.org',
            getenv('GROUP_ID'),
            false,
            [
                'salutation' => 'Mr.',
                'firstname' => 'John',
                'lastname' => 'Doe',
            ]
        );

        $this->assertArrayHasKey('email', $response);
        $this->assertEquals('john.doe@example.org', $response['email']);
    }

    public function testAddCreateSubscriber()
    {
        $groupId = getenv('GROUP_ID');
        self::$apiManager->addCreateSubscriber(
            'john.doe.2@example.org',
            $groupId,
            false,
            [
                'salutation' => 'Mr.',
                'firstname' => 'John',
                'lastname' => 'Doe',
            ]
        );
        self::$apiManager->addCreateSubscriber(
            'jane.doe.2@example.org',
            $groupId,
            false,
            [
                'salutation' => 'Mr.',
                'firstname' => 'John',
                'lastname' => 'Doe',
            ]
        );
        $response = self::$apiManager->flush();

        $this->assertCount(1, $response);
        $this->assertArrayHasKey($groupId, $response);
        $this->assertCount(2, $response[$groupId]);
        $this->assertEquals('insert success', $response[$groupId][0]['status']);
    }

    public function testGetSubscriber()
    {
        $response = self::$apiManager->getSubscriber(
            'john.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertArrayHasKey('email', $response);
        $this->assertEquals('john.doe@example.org', $response['email']);

        $response = self::$apiManager->getSubscriber(
            'jane.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertArrayHasKey('error', $response);
        $this->assertArraySubset(
            $response,
            [
                'error' => [
                    'code' => 404,
                    'message' => 'Not Found: invalid receiver',
                ],
            ]
        );
    }

    public function testSetSubscriberStatus()
    {
        $response = self::$apiManager->setSubscriberStatus(
            'john.doe@example.org',
            getenv('GROUP_ID'),
            true
        );

        $this->assertTrue($response);

        $response = self::$apiManager->getSubscriber(
            'john.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertArrayHasKey('active', $response);
        $this->assertTrue($response['active']);

        $response = self::$apiManager->setSubscriberStatus(
            'john.doe@example.org',
            getenv('GROUP_ID'),
            false
        );

        $this->assertTrue($response);

        $response = self::$apiManager->getSubscriber(
            'john.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertArrayHasKey('active', $response);
        $this->assertFalse($response['active']);
    }

    public function testDeleteSubscriber()
    {
        $groupId = getenv('GROUP_ID');
        $response = self::$apiManager->deleteSubscriber(
            'john.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertTrue($response);

        $response = self::$apiManager->deleteSubscriber(
            'jane.doe@example.org',
            getenv('GROUP_ID')
        );

        $this->assertArrayHasKey('error', $response);
        $this->assertArraySubset(
            $response,
            [
                'error' => [
                    'code' => 404,
                    'message' => 'Not Found: invalid receiver',
                ],
            ]
        );

        self::$apiManager->deleteSubscriber(
            'john.doe.2@example.org',
            $groupId
        );
        self::$apiManager->deleteSubscriber(
            'jane.doe.2@example.org',
            $groupId
        );
    }
}

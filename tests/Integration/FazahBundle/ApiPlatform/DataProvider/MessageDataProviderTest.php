<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\FazahBundle\ApiPlatform\DataProvider;

use Eps\Fazah\FazahBundle\ApiPlatform\DataProvider\MessageDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

class MessageDataProviderTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = $this->makeClient();
        $this->loadFixtures([
            AddFewMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldReturnAllMessages(): void
    {
        $requestUrl = '/api/messages.json';
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => '84decc43-283f-4089-8ded-f66513d1b54d',
                'translation' => [
                    'message_key' => 'my.message.3',
                    'translated_message' => 'My message #3',
                    'language' => 'fr'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:03+00:00',
                    'update_time' => '2016-03-02T12:00:03+00:00',
                    'enabled' => true
                ]
            ],
            [
                'id' => 'fad9c222-02c6-4466-82f8-9345a84b52da',
                'translation' => [
                    'message_key' => 'my.message.2',
                    'translated_message' => 'My message #2',
                    'language' => 'pl'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:02+00:00',
                    'update_time' => '2016-03-02T12:00:02+00:00',
                    'enabled' => true
                ]
            ],
            [
                'id' => 'af797da0-0959-4207-97f5-3dabf081a37f',
                'translation' => [
                    'message_key' => 'my.message.1',
                    'translated_message' => 'My message #1',
                    'language' => 'en'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:01+00:00',
                    'update_time' => '2016-03-02T12:00:01+00:00',
                    'enabled' => true
                ]
            ]
        ]);

        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldGetMessagesByPhrase(): void
    {
        $phrase = 'message.1';
        $requestUrl = "/api/messages.json?phrase=$phrase";
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => 'af797da0-0959-4207-97f5-3dabf081a37f',
                'translation' => [
                    'message_key' => 'my.message.1',
                    'translated_message' => 'My message #1',
                    'language' => 'en'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:01+00:00',
                    'update_time' => '2016-03-02T12:00:01+00:00',
                    'enabled' => true
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldFindMessageByCatalogueId(): void
    {
        $catalogueId = '94b1c887-f740-454a-b94e-706a0e5a0f41';
        $requestUrl = "/api/messages.json?catalogue_id=$catalogueId";
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => '84decc43-283f-4089-8ded-f66513d1b54d',
                'translation' => [
                    'message_key' => 'my.message.3',
                    'translated_message' => 'My message #3',
                    'language' => 'fr'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:03+00:00',
                    'update_time' => '2016-03-02T12:00:03+00:00',
                    'enabled' => true
                ]
            ],
            [
                'id' => 'fad9c222-02c6-4466-82f8-9345a84b52da',
                'translation' => [
                    'message_key' => 'my.message.2',
                    'translated_message' => 'My message #2',
                    'language' => 'pl'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:02+00:00',
                    'update_time' => '2016-03-02T12:00:02+00:00',
                    'enabled' => true
                ]
            ],
            [
                'id' => 'af797da0-0959-4207-97f5-3dabf081a37f',
                'translation' => [
                    'message_key' => 'my.message.1',
                    'translated_message' => 'My message #1',
                    'language' => 'en'
                ],
                'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
                'metadata' => [
                    'creation_time' => '2016-03-01T12:00:01+00:00',
                    'update_time' => '2016-03-02T12:00:01+00:00',
                    'enabled' => true
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldGetMessageById(): void
    {
        $messageId = 'af797da0-0959-4207-97f5-3dabf081a37f';
        $requestUrl = "/api/messages/$messageId.json";
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            'id' => 'af797da0-0959-4207-97f5-3dabf081a37f',
            'translation' => [
                'message_key' => 'my.message.1',
                'translated_message' => 'My message #1',
                'language' => 'en'
            ],
            'catalogue_id' => '94b1c887-f740-454a-b94e-706a0e5a0f41',
            'metadata' => [
                'creation_time' => '2016-03-01T12:00:01+00:00',
                'update_time' => '2016-03-02T12:00:01+00:00',
                'enabled' => true
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }
}

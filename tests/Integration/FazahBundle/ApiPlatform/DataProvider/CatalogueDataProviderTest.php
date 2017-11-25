<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\FazahBundle\ApiPlatform\DataProvider;

use Eps\Fazah\Tests\Resources\Fixtures\AddFewCatalogues;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

class CatalogueDataProviderTest extends WebTestCase
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
            AddFewCatalogues::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldGetAllCatalogues(): void
    {
        $requestUrl = '/api/catalogues.json';
        $this->client->request('GET', $requestUrl);
        $expectedResponse = json_encode([
            [
                'id' => '12853ef6-43a5-4e7f-8ff5-3fb47ef10a07',
                'name' => 'first_catalogue',
                'alias' => 'first_catalogue',
                'project_id' => '584d8b6a-7eb0-4ef4-a54e-0eb16bb86138',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => true
                ]
            ],
            [
                'id' => 'aba1afb9-8513-4657-844c-8df297e335b4',
                'name' => 'second_catalogue',
                'alias' => 'second_catalogue',
                'project_id' => '584d8b6a-7eb0-4ef4-a54e-0eb16bb86138',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => false
                ]
            ],
            [
                'id' => 'cf5f781a-3f05-45cd-bbe4-f09ed61227e3',
                'name' => 'third_catalogue',
                'alias' => 'third_catalogue',
                'project_id' => '0bacbf16-dfc8-4e39-9ca1-581d9158c3d5',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
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
    public function itShouldGetAllCataloguesByProjectId(): void
    {
        $projectId = '0bacbf16-dfc8-4e39-9ca1-581d9158c3d5';
        $requestUrl = "/api/catalogues.json?project_id=$projectId";
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => 'cf5f781a-3f05-45cd-bbe4-f09ed61227e3',
                'name' => 'third_catalogue',
                'alias' => 'third_catalogue',
                'project_id' => '0bacbf16-dfc8-4e39-9ca1-581d9158c3d5',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => true
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturnAllCataloguesByState(): void
    {
        $requestUrl = '/api/catalogues.json?enabled=false';
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => 'aba1afb9-8513-4657-844c-8df297e335b4',
                'name' => 'second_catalogue',
                'alias' => 'second_catalogue',
                'project_id' => '584d8b6a-7eb0-4ef4-a54e-0eb16bb86138',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => false
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturnAllCataloguesByPhrase(): void
    {
        $phrase = 'third';
        $requestUrl = "/api/catalogues.json?phrase=$phrase";
        $this->client->request('GET', $requestUrl);

        $expectedResponse = json_encode([
            [
                'id' => 'cf5f781a-3f05-45cd-bbe4-f09ed61227e3',
                'name' => 'third_catalogue',
                'alias' => 'third_catalogue',
                'project_id' => '0bacbf16-dfc8-4e39-9ca1-581d9158c3d5',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => true
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturnSingleCatalogueById(): void
    {
        $catalogueId = '12853ef6-43a5-4e7f-8ff5-3fb47ef10a07';
        $requestUrl = "/api/catalogues/$catalogueId.json";
        $this->client->request('GET', $requestUrl);

        $expectedCatalogue = json_encode([
            'id' => '12853ef6-43a5-4e7f-8ff5-3fb47ef10a07',
            'name' => 'first_catalogue',
            'alias' => 'first_catalogue',
            'project_id' => '584d8b6a-7eb0-4ef4-a54e-0eb16bb86138',
            'parent_catalogue_id' => null,
            'metadata' => [
                'creation_time' => '2015-01-01T12:00:00+00:00',
                'update_time' => '2015-01-02T13:00:00+00:00',
                'enabled' => true
            ]
        ]);
        $actualCatalogue = $this->client->getResponse()->getContent();

        static::assertEquals($expectedCatalogue, $actualCatalogue);
    }

    /**
     * @test
     */
    public function itShouldRemoveCatalogueById(): void
    {
        $requestUrl = '/api/catalogues/12853ef6-43a5-4e7f-8ff5-3fb47ef10a07.json';
        $this->client->request('DELETE', $requestUrl);

        $actualResponse = $this->client->getResponse();

        static::assertEquals(204, $actualResponse->getStatusCode());
        static::assertEmpty($actualResponse->getContent());

        $expectedCatalogues = json_encode([
            [
                'id' => 'aba1afb9-8513-4657-844c-8df297e335b4',
                'name' => 'second_catalogue',
                'alias' => 'second_catalogue',
                'project_id' => '584d8b6a-7eb0-4ef4-a54e-0eb16bb86138',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => false
                ]
            ],
            [
                'id' => 'cf5f781a-3f05-45cd-bbe4-f09ed61227e3',
                'name' => 'third_catalogue',
                'alias' => 'third_catalogue',
                'project_id' => '0bacbf16-dfc8-4e39-9ca1-581d9158c3d5',
                'parent_catalogue_id' => null,
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:00+00:00',
                    'update_time' => '2015-01-02T13:00:00+00:00',
                    'enabled' => true
                ]
            ]
        ]);

        $this->client->request('GET', '/api/catalogues.json');
        $actualCatalogues = $this->client->getResponse()->getContent();

        static::assertEquals($expectedCatalogues, $actualCatalogues);
    }
}

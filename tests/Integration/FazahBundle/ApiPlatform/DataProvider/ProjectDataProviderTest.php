<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\FazahBundle\ApiPlatform\DataProvider;

use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Client;

class ProjectDataProviderTest extends WebTestCase
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
            AddProjects::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldGetAllProjects(): void
    {
        $requestUrl = '/api/projects.json';
        $this->client->request('GET', $requestUrl);
        $expectedResponse = json_encode([
            [
                'id' => '9b669c76-7a80-4d3f-9191-37c1eda80a05',
                'name' => 'disabled-project',
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:03+00:00',
                    'update_time' => '2015-01-02T12:00:03+00:00',
                    'enabled' => false
                ],
                'config' => [
                    'available_languages' => ['en', 'fr', 'pl']
                ]
            ],
            [
                'id' => '4c3339d3-ad42-4614-bd83-8585cea0e54e',
                'name' => 'yet-another-cool-project',
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:02+00:00',
                    'update_time' => '2015-01-02T12:00:02+00:00',
                    'enabled' => true
                ],
                'config' => [
                    'available_languages' => ['en', 'fr', 'pl']
                ]
            ],
            [
                'id' => 'a558d385-a0b4-4f0d-861c-da6b9cd83260',
                'name' => 'my-awesome-project',
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:01+00:00',
                    'update_time' => '2015-01-02T12:00:01+00:00',
                    'enabled' => true
                ],
                'config' => [
                    'available_languages' => ['en', 'fr', 'pl']
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldGetAllProjectsFilteredByState(): void
    {
        $requestUrl = '/api/projects.json?enabled=false';
        $this->client->request('GET', $requestUrl);
        $expectedResponse = json_encode([
            [
                'id' => '9b669c76-7a80-4d3f-9191-37c1eda80a05',
                'name' => 'disabled-project',
                'metadata' => [
                    'creation_time' => '2015-01-01T12:00:03+00:00',
                    'update_time' => '2015-01-02T12:00:03+00:00',
                    'enabled' => false
                ],
                'config' => [
                    'available_languages' => ['en', 'fr', 'pl']
                ]
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldGetProjectById(): void
    {
        $requestUrl = '/api/projects/9b669c76-7a80-4d3f-9191-37c1eda80a05.json';
        $this->client->request('GET', $requestUrl);
        $expectedResponse = json_encode([
            'id' => '9b669c76-7a80-4d3f-9191-37c1eda80a05',
            'name' => 'disabled-project',
            'metadata' => [
                'creation_time' => '2015-01-01T12:00:03+00:00',
                'update_time' => '2015-01-02T12:00:03+00:00',
                'enabled' => false
            ],
            'config' => [
                'available_languages' => ['en', 'fr', 'pl']
            ]
        ]);
        $actualResponse = $this->client->getResponse()->getContent();

        static::assertJsonStringEqualsJsonString($expectedResponse, $actualResponse);
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\EventListener;

use Eps\Fazah\FazahBundle\EventListener\CommandExtractor\MockCommandExtractor;
use Eps\Fazah\FazahBundle\EventListener\ExtractCommandFromRequestListener;
use Eps\Fazah\Tests\Resources\Fixtures\SerializableCommand\DummySerializableCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class ExtractCommandFromRequestListenerTest extends TestCase
{
    /**
     * @var ExtractCommandFromRequestListener
     */
    private $listener;

    /**
     * @var MockCommandExtractor
     */
    private $extractor;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extractor = new MockCommandExtractor();
        $this->listener = new ExtractCommandFromRequestListener($this->extractor);
    }

    /**
     * @test
     */
    public function itShouldExtractCommandFromARequest(): void
    {
        $request = $this->getValidRequest();
        $event = $this->createGetResponseEvent($request);
        $deserializedCommand = new DummySerializableCommand('My command', ['a' => 1]);
        $this->extractor->willReturn($deserializedCommand);

        $this->listener->onKernelRequest($event);

        $expectedCommand = $deserializedCommand;
        $actualCommand = $request->attributes->get('_command');

        static::assertEquals($expectedCommand, $actualCommand);
    }

    /**
     * @test
     */
    public function itShouldSetAControllerForCommandRequest(): void
    {
        $request = $this->getValidRequest();
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        $expectedRoute = ExtractCommandFromRequestListener::API_RESPONDER_CONTROLLER;
        $actualRoute = $request->get('_controller');

        static::assertEquals($expectedRoute, $actualRoute);
    }

    /**
     * @test
     */
    public function itShouldCleanUpCommandClassParameter(): void
    {
        $request = $this->getValidRequest();
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        static::assertFalse($request->attributes->has('_command_class'));
    }

    /**
     * @test
     */
    public function itShouldDoNothingWhenCommandClassIsNotProvided(): void
    {
        $request = $this->getValidRequest();
        $request->attributes->remove('_command_class');
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        static::assertFalse($request->attributes->has('_command'));
    }

    private function createGetResponseEvent(Request $request): GetResponseEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $requestType = HttpKernelInterface::MASTER_REQUEST;

        return new GetResponseEvent($kernel, $request, $requestType);
    }

    private function getValidRequest(): Request
    {
        $requestBody = json_encode([
            'name' => 'My command',
            'opts' => ['a' => 1]
        ]);
        $requestAttributes = [
            '_command_class' => DummySerializableCommand::class
        ];
        $request = new Request([], [], $requestAttributes, [], [], [], $requestBody);
        $request->setRequestFormat('json');

        return $request;
    }
}

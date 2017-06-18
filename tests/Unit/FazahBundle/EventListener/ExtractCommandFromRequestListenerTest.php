<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\EventListener;

use Eps\Fazah\FazahBundle\EventListener\ExtractCommandFromRequestListener;
use Eps\Fazah\FazahBundle\Normalizer\SerializableCommandDenormalizer;
use Eps\Fazah\Tests\Resources\Fixtures\SerializableCommand\DummySerializableCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class ExtractCommandFromRequestListenerTest extends TestCase
{
    /**
     * @var ExtractCommandFromRequestListener
     */
    private $listener;

    protected function setUp(): void
    {
        parent::setUp();

        $serializer = new Serializer(
            [new SerializableCommandDenormalizer()],
            [new JsonEncoder()]
        );
        $this->listener = new ExtractCommandFromRequestListener($serializer);
    }

    /**
     * @test
     */
    public function itShouldConvertDeserializeRequestToCommand(): void
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
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        $expectedCommand = new DummySerializableCommand('My command', ['a' => 1]);
        $actualCommand = $request->attributes->get('_command');

        static::assertEquals($expectedCommand, $actualCommand);
    }

    /**
     * @test
     */
    public function itShouldSetAControllerForCommandRequest(): void
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
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        $expectedRoute = ExtractCommandFromRequestListener::API_RESPONDER_CONTROLLER;
        $actualRoute = $request->get('_controller');

        static::assertEquals($expectedRoute, $actualRoute);
    }

    /**
     * @test
     */
    public function itShouldDoNothingWhenCommandClassIsNotProvided(): void
    {
        $requestBody = json_encode([
            'name' => 'My command',
            'opts' => ['a' => 1]
        ]);
        $requestAttributes = [];
        $request = new Request([], [], $requestAttributes, [], [], [], $requestBody);
        $request->setRequestFormat('json');
        $event = $this->createGetResponseEvent($request);

        $this->listener->onKernelRequest($event);

        static::assertNull($request->attributes->get('_command'));
    }

    private function createGetResponseEvent(Request $request): GetResponseEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $requestType = HttpKernelInterface::MASTER_REQUEST;

        return new GetResponseEvent($kernel, $request, $requestType);
    }
}

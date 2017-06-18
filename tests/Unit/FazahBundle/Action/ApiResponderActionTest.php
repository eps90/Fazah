<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\Action;

use Eps\Fazah\FazahBundle\Action\ApiResponderAction;
use League\Tactician\CommandBus;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiResponderActionTest extends TestCase
{
    /**
     * @var ApiResponderAction
     */
    private $action;

    /**
     * @var CommandBus|\PHPUnit_Framework_MockObject_MockObject
     */
    private $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->createMock(CommandBus::class);
        $this->action = new ApiResponderAction($this->commandBus);
    }

    /**
     * @test
     */
    public function itShouldSendACommandToTheEventBus(): void
    {
        $requestedCommand = new \stdClass();
        $request = new Request();
        $request->attributes->set('_command', $requestedCommand);

        $this->commandBus->expects(static::once())
           ->method('handle')
           ->with($requestedCommand);

        call_user_func($this->action, $request);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenCommandIsNotSet(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidRequest = new Request();

        call_user_func($this->action, $invalidRequest);
    }

    /**
     * @test
     */
    public function itShouldReturn200ResponseForGetRequests(): void
    {
        $request = new Request([], [], ['_command' => new \stdClass()]);
        $request->setMethod(Request::METHOD_GET);

        $actualResponse = call_user_func($this->action, $request);
        $expectedResponse = new Response('', Response::HTTP_OK);

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturn201ForPostRequests(): void
    {
        $request = new Request([], [], ['_command' => new \stdClass()]);
        $request->setMethod(Request::METHOD_POST);

        $actualResponse = call_user_func($this->action, $request);
        $expectedResponse = new Response('', Response::HTTP_CREATED);

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturn201ForPutRequests(): void
    {
        $request = new Request([], [], ['_command' => new \stdClass()]);
        $request->setMethod(Request::METHOD_PUT);

        $actualResponse = call_user_func($this->action, $request);
        $expectedResponse = new Response('', Response::HTTP_CREATED);

        static::assertEquals($expectedResponse, $actualResponse);
    }

    /**
     * @test
     */
    public function itShouldReturn204ForDeleteRequests(): void
    {
        $request = new Request([], [], ['_command' => new \stdClass()]);
        $request->setMethod(Request::METHOD_DELETE);

        $actualResponse = call_user_func($this->action, $request);
        $expectedResponse = new Response('', Response::HTTP_NO_CONTENT);

        static::assertEquals($expectedResponse, $actualResponse);
    }
}

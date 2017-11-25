<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Handler\Message\RemoveMessageHandler;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMessage;
use PHPUnit\Framework\TestCase;

class RemoveMessageHandlerTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageRepo;
    
    /**
     * @var RemoveMessageHandler
     */
    private $handler;
    
    protected function setUp()
    {
        parent::setUp();
        
        $this->messageRepo = $this->createMock(MessageRepository::class);
        $this->handler = new RemoveMessageHandler($this->messageRepo);
    }
    
    /**
     * @test
     */
    public function itShouldRemoveAMessageFromRepo(): void
    {
        $messageId = new MessageId('af797da0-0959-4207-97f5-3dabf081a37f');
        $command = new RemoveMessage($messageId);
        
        $this->messageRepo->expects(static::once())
            ->method('remove')
            ->with($messageId);
        
        $this->handler->handle($command);
    }
}

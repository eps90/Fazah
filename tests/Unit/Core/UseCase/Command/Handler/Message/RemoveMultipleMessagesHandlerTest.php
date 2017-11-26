<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Handler\Message\RemoveMultipleMessagesHandler;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMultipleMessages;
use PHPUnit\Framework\TestCase;

class RemoveMultipleMessagesHandlerTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageRepo;

    /**
     * @var RemoveMultipleMessagesHandler
     */
    private $handler;

    protected function setUp()
    {
        parent::setUp();

        $this->messageRepo = $this->createMock(MessageRepository::class);
        $this->handler = new RemoveMultipleMessagesHandler($this->messageRepo);
    }

    /**
     * @test
     */
    public function itShouldRemoveMultipleMessagesFromRepo(): void
    {
        $messageIds = [
            new MessageId('af797da0-0959-4207-97f5-3dabf081a37f'),
            new MessageId('fad9c222-02c6-4466-82f8-9345a84b52da')
        ];
        $command = new RemoveMultipleMessages($messageIds);

        $this->messageRepo->expects(static::once())
            ->method('removeMultiple')
            ->with(...$messageIds);

        $this->handler->handle($command);
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Message\ChangeMessageState;
use Eps\Fazah\Core\UseCase\Command\Handler\Message\ChangeMessageStateHandler;
use Eps\Fazah\Core\Utils\DateTimeFactory;
use PHPUnit\Framework\TestCase;

class ChangeMessageStateHandlerTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageRepo;

    /**
     * @var ChangeMessageStateHandler
     */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageRepo = $this->createMock(MessageRepository::class);
        $this->handler = new ChangeMessageStateHandler($this->messageRepo);
        DateTimeFactory::freezeDate(new \DateTimeImmutable('2016-04-14 15:06:12'));
    }

    protected function tearDown()
    {
        parent::tearDown();
        DateTimeFactory::unfreezeDate();
    }


    /**
     * @test
     */
    public function itShouldChangeMessageStateToDisabled(): void
    {
        $messageId = MessageId::generate();
        $enabled = false;
        $command = new ChangeMessageState($messageId, $enabled);

        $existingMessage = Message::restoreFrom(
            $messageId,
            Translation::create(
                'my.message',
                'My translation',
                'en'
            ),
            CatalogueId::generate(),
            Metadata::restoreFrom(
                DateTimeFactory::now(),
                DateTimeFactory::now(),
                true
            )
        );
        $this->messageRepo->expects($this->once())
            ->method('find')
            ->with($messageId)
            ->willReturn($existingMessage);
        $this->messageRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Message $message) use ($messageId, $enabled) {
                        return $message->getId() === $messageId
                            && $message->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }

    /**
     * @test
     */
    public function itShouldChangeCatalogueStateToEnabled(): void
    {
        $messageId = MessageId::generate();
        $enabled = true;
        $command = new ChangeMessageState($messageId, $enabled);

        $existingCatalogue = Message::restoreFrom(
            $messageId,
            Translation::create(
                'my.message',
                'My translation',
                'en'
            ),
            CatalogueId::generate(),
            Metadata::restoreFrom(
                DateTimeFactory::now(),
                DateTimeFactory::now(),
                false
            )
        );
        $this->messageRepo->expects($this->once())
            ->method('find')
            ->with($messageId)
            ->willReturn($existingCatalogue);
        $this->messageRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Message $message) use ($messageId, $enabled) {
                        return $message->getId() === $messageId
                            && $message->getMetadata()->isEnabled() === $enabled;
                    }
                )
            );

        $this->handler->handle($command);
    }
}

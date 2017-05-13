<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\EditMessage;
use Eps\Fazah\Core\UseCase\Command\Handler\EditMessageHandler;
use PHPUnit\Framework\TestCase;

class EditMessageHandlerTest extends TestCase
{
    /**
     * @var MessageRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    private $messageRepo;

    /**
     * @var EditMessageHandler
     */
    private $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->messageRepo = $this->createMock(MessageRepository::class);
        $this->handler = new EditMessageHandler($this->messageRepo);
    }

    /**
     * @test
     */
    public function itShouldUpdateMessageWithRepository(): void
    {
        $messageId = MessageId::generate();
        $newMessageKey = 'update.message.key';
        $translatedMessage = 'My translated message';
        $updateMap = [
            'message_key' => $newMessageKey,
            'translated_message' => $translatedMessage
        ];
        $command = new EditMessage($messageId, $updateMap);

        $this->messageRepo->expects($this->once())
            ->method('find')
            ->with($messageId)
            ->willReturn(
                Message::restoreFrom(
                    $messageId,
                    Translation::untranslated(
                        'old.message.key',
                        'fr'
                    ),
                    CatalogueId::generate(),
                    Metadata::initialize()
                )
            );

        $this->messageRepo->expects($this->once())
            ->method('save')
            ->with(
                $this->callback(
                    function (Message $message) use ($messageId, $newMessageKey, $translatedMessage) {
                        return $message->getId() === $messageId
                            && $message->getTranslation()->getMessageKey() === $newMessageKey
                            && $message->getTranslation()->getTranslatedMessage() === $translatedMessage;
                    }
                )
            );

        $this->handler->handle($command);
    }
}

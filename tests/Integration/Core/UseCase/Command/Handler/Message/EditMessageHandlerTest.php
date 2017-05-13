<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\EditMessage;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class EditMessageHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->commandBus = $this->getContainer()->get('tactician.commandbus');
        $this->loadFixtures([
            AddFewMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldSaveUpdatedMessage(): void
    {
        $messageId = new MessageId('af797da0-0959-4207-97f5-3dabf081a37f');
        $newMessageKey = 'new.message.key';
        $translatedMessage = 'This is translated message';
        $updateMap = [
            'message_key' => $newMessageKey,
            'translated_message' => $translatedMessage
        ];
        $command = new EditMessage($messageId, $updateMap);

        $this->commandBus->handle($command);

        $messageRepo = $this->getContainer()->get('fazah.repository.message');
        $message = $messageRepo->find($messageId);

        static::assertEquals($newMessageKey, $message->getTranslation()->getMessageKey());
        static::assertEquals($translatedMessage, $message->getTranslation()->getTranslatedMessage());
    }
}

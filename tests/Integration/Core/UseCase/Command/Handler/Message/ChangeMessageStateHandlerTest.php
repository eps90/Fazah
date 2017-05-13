<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\UseCase\Command\Message\ChangeMessageState;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class ChangeMessageStateHandlerTest extends WebTestCase
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
    public function itShouldChangeMessageState(): void
    {
        $messageId = new MessageId('af797da0-0959-4207-97f5-3dabf081a37f');
        $enabled = false;
        $command = new ChangeMessageState($messageId, $enabled);

        $this->commandBus->handle($command);

        $messageRepo = $this->getContainer()->get('fazah.repository.message');
        $modifiedMessage = $messageRepo->find($messageId);

        static::assertFalse($modifiedMessage->getMetadata()->isEnabled());
    }
}

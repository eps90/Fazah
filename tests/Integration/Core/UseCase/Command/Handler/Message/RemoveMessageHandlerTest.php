<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMessage;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class RemoveMessageHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var MessageRepository
     */
    private $messagesRepo;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $this->commandBus = $container->get('test.tactician.commandbus');
        $this->messagesRepo = $container->get('test.fazah.repository.message');
        $this->loadFixtures([
            AddFewMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldRemoveAMessageInARepo(): void
    {
        $messageId = new MessageId('af797da0-0959-4207-97f5-3dabf081a37f');
        $command = new RemoveMessage($messageId);

        $this->commandBus->handle($command);

        $this->expectException(MessageRepositoryException::class);
        $this->messagesRepo->find($messageId);
    }
}

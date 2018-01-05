<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\UseCase\Command\Handler\Message;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\MessageRepository;
use Eps\Fazah\Core\UseCase\Command\Message\RemoveMultipleMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use League\Tactician\CommandBus;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class RemoveMultipleMessagesHandlerTest extends WebTestCase
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var MessageRepository
     */
    private $messageRepo;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $this->commandBus = $container->get('test.tactician.commandbus');
        $this->messageRepo = $container->get('test.fazah.repository.message');
        $this->loadFixtures([
            AddFewMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldRemoveMultipleMessagesAtOnce(): void
    {
        $messageIds = [
            new MessageId('af797da0-0959-4207-97f5-3dabf081a37f'),
            new MessageId('fad9c222-02c6-4466-82f8-9345a84b52da')
        ];
        $command = new RemoveMultipleMessages($messageIds);

        $this->commandBus->handle($command);

        $expectedMessages = [
            Message::restoreFrom(
                new MessageId('84decc43-283f-4089-8ded-f66513d1b54d'),
                Translation::create(
                    'my.message.3',
                    'My message #3',
                    'fr'
                ),
                new CatalogueId('94b1c887-f740-454a-b94e-706a0e5a0f41'),
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:03'),
                    new \DateTimeImmutable('2016-03-02 12:00:03'),
                    true
                )
            )
        ];
        $actualMessages = iterator_to_array($this->messageRepo->findAll());

        static::assertEquals($expectedMessages, $actualMessages);
    }
}

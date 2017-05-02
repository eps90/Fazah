<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Repository\DoctrineMessageRepository;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DoctrineMessageRepositoryTest extends WebTestCase
{
    /**
     * @var DoctrineMessageRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $this->repository = new DoctrineMessageRepository($entityManager);

        $this->loadFixtures([
            AddProjects::class,
            AddCatalogues::class,
            AddMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldFindMessageById(): void
    {
        $messageId = new MessageId('09d55f8b-4567-45e8-b9a0-0ce2ad2e7281');

        $expectedMessage = Message::restoreFrom(
            $messageId,
            'test.message.6',
            'Hello from message #6 in language pl!',
            'pl',
            Carbon::instance(new \DateTime('2015-01-01 12:00:10')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:10')),
            true,
            new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
        );
        $actualMessage = $this->repository->find($messageId);

        static::assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenMessageHasNotBeenFound(): void
    {
        $this->expectException(MessageRepositoryException::class);

        $missingMessageId = MessageId::generate();

        $this->repository->find($missingMessageId);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToSaveNewMessage(): void
    {
        $messageId = MessageId::generate();

        $messageToAdd = Message::restoreFrom(
            $messageId,
            'my.test.message',
            'Hello from message !',
            'pl',
            Carbon::instance(new \DateTime('2015-01-01 12:00:10')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:10')),
            true,
            new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
        );
        $this->repository->add($messageToAdd);

        $expectedMessage = $messageToAdd;
        $actualMessage = $this->repository->find($messageId);

        static::assertEquals($expectedMessage, $actualMessage);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddMultipleMessages(): void
    {
        $firstMessage = Message::create(
            'my.message',
            'My message',
            'fr',
            new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
        );
        $secondMessage = Message::create(
            'my.message',
            'My message',
            'fr',
            new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
        );

        $this->repository->add($firstMessage, $secondMessage);

        static::assertEquals($firstMessage, $this->repository->find($firstMessage->getMessageId()));
        static::assertEquals($secondMessage, $this->repository->find($secondMessage->getMessageId()));
    }

    /**
     * @test
     */
    public function itShouldFindMessagesByCatalogueId(): void
    {
        $catalogueId = new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425');

        $expectedMessages = [
            Message::restoreFrom(
                new MessageId('0ec85c11-5153-4de9-b44c-442cb8f57a88'),
                'test.message.3',
                'Hello from message #3 in language fr!',
                'fr',
                Carbon::instance(new \DateTime('2015-01-01 12:00:20')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:20')),
                true,
                $catalogueId
            ),
            Message::restoreFrom(
                new MessageId('a9933d3c-d35f-482e-9b8a-3be629936f36'),
                'test.message.3',
                'Hello from message #3 in language pl!',
                'pl',
                Carbon::instance(new \DateTime('2015-01-01 12:00:19')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:19')),
                true,
                $catalogueId
            ),
            Message::restoreFrom(
                new MessageId('01892f4a-e15a-44b6-a3e8-03441d94d902'),
                'test.message.3',
                'Hello from message #3 in language en!',
                'en',
                Carbon::instance(new \DateTime('2015-01-01 12:00:18')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:18')),
                true,
                $catalogueId
            )
        ];
        $actualResult = $this->repository->findByCatalogueId($catalogueId);

        static::assertEquals($expectedMessages, $actualResult);
    }
}

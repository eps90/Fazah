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
            Carbon::instance(new \DateTime('2015-01-01 12:00:00')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:00')),
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
            Carbon::instance(new \DateTime('2015-01-01 12:00:00')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:00')),
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
    public function itShouldThrowOnDuplicatedMessageId(): void
    {
        $this->expectException(MessageRepositoryException::class);

        $duplicatedId = new MessageId('09d55f8b-4567-45e8-b9a0-0ce2ad2e7281');

        $messageToAdd = Message::restoreFrom(
            $duplicatedId,
            'my.test.message',
            'Hello from message !',
            'pl',
            Carbon::instance(new \DateTime('2015-01-01 12:00:00')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:00')),
            true,
            new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
        );
        $this->repository->add($messageToAdd);
    }
}

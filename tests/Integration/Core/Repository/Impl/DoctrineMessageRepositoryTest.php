<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\MessageRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddFewMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineMessageRepositoryTest extends DoctrineRepositoryTest
{
    use MessageRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        return $this->getContainer()->get('test.fazah.repository.message');
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class,
            AddCatalogues::class,
            AddMessages::class
        ];
    }

    /**
     * @test
     */
    public function itShouldFindAllMessages(): void
    {
        $this->loadFixtures([
            AddFewMessages::class
        ]);
        $expectedResult = [
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
            ),
            Message::restoreFrom(
                new MessageId('fad9c222-02c6-4466-82f8-9345a84b52da'),
                Translation::create(
                    'my.message.2',
                    'My message #2',
                    'pl'
                ),
                new CatalogueId('94b1c887-f740-454a-b94e-706a0e5a0f41'),
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:02'),
                    new \DateTimeImmutable('2016-03-02 12:00:02'),
                    true
                )
            ),
            Message::restoreFrom(
                new MessageId('af797da0-0959-4207-97f5-3dabf081a37f'),
                Translation::create(
                    'my.message.1',
                    'My message #1',
                    'en'
                ),
                new CatalogueId('94b1c887-f740-454a-b94e-706a0e5a0f41'),
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:01'),
                    new \DateTimeImmutable('2016-03-02 12:00:01'),
                    true
                )
            )
        ];
        $actualResult = iterator_to_array($this->getRepositoryInstance()->findAll());

        static::assertEquals($expectedResult, $actualResult);
    }

    /**
     * @test
     */
    public function itShouldRemoveMultipleMessages(): void
    {
        $this->loadFixtures([
            AddFewMessages::class
        ]);

        $messageIds = [
            new MessageId('fad9c222-02c6-4466-82f8-9345a84b52da'),
            new MessageId('af797da0-0959-4207-97f5-3dabf081a37f')
        ];

        $repository = $this->getRepositoryInstance();
        $repository->removeMultiple(...$messageIds);

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
        $actualMessages = iterator_to_array($repository->findAll());

        static::assertEquals($expectedMessages, $actualMessages);
    }
}

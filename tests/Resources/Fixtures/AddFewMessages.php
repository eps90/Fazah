<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Resources\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;

final class AddFewMessages extends AbstractFixture
{
    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $catalogueId = new CatalogueId('94b1c887-f740-454a-b94e-706a0e5a0f41');
        $catalogue = Catalogue::restoreFrom(
            $catalogueId,
            'Lonely catalogue',
            new ProjectId('ff054881-6ddb-4f78-bdfb-681068b610ee'),
            null,
            Metadata::restoreFrom(
                new \DateTimeImmutable('2016-03-01 12:00:00'),
                new \DateTimeImmutable('2016-03-02 12:00:00'),
                true
            )
        );

        $manager->persist($catalogue);

        $messages = [
            Message::restoreFrom(
                new MessageId('af797da0-0959-4207-97f5-3dabf081a37f'),
                Translation::create(
                    'my.message.1',
                    'My message #1',
                    'en'
                ),
                $catalogueId,
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:01'),
                    new \DateTimeImmutable('2016-03-02 12:00:01'),
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
                $catalogueId,
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:02'),
                    new \DateTimeImmutable('2016-03-02 12:00:02'),
                    true
                )
            ),
            Message::restoreFrom(
                new MessageId('84decc43-283f-4089-8ded-f66513d1b54d'),
                Translation::create(
                    'my.message.3',
                    'My message #3',
                    'fr'
                ),
                $catalogueId,
                Metadata::restoreFrom(
                    new \DateTimeImmutable('2016-03-01 12:00:03'),
                    new \DateTimeImmutable('2016-03-02 12:00:03'),
                    true
                )
            )
        ];

        foreach ($messages as $message) {
            $manager->persist($message);
        }

        $manager->flush();
    }
}

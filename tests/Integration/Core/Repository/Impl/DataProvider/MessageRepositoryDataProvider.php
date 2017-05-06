<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\MessageId;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\Core\Model\ValueObject\Metadata;
use Eps\Fazah\Core\Model\ValueObject\Translation;
use Eps\Fazah\Core\Repository\Exception\MessageRepositoryException;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

trait MessageRepositoryDataProvider
{
    public function modelIdProvider(): array
    {
        return [
            [
                'message_id' => new MessageId('09d55f8b-4567-45e8-b9a0-0ce2ad2e7281'),
                'expected'=> Message::restoreFrom(
                    new MessageId('09d55f8b-4567-45e8-b9a0-0ce2ad2e7281'),
                    Translation::create(
                        'test.message.6',
                        'Hello from message #6 in language pl!',
                        'pl'
                    ),
                    new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                    Metadata::restoreFrom(
                        Carbon::parse('2015-01-01 12:00:13'),
                        Carbon::parse('2015-01-02 12:00:13'),
                        true
                    )
                )
            ]
        ];
    }

    public function missingModelProvider(): array
    {
        return [
            [
                'message_id' => MessageId::generate(),
                'exception_class' => MessageRepositoryException::class
            ]
        ];
    }

    public function saveProvider(): array
    {
        return [
            [
                'messages' => [
                    Message::create(
                        Translation::create(
                            'my_message',
                            'Hello!',
                            'en'
                        ),
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
                    )
                ],
                'id_method' => 'getMessageId'
            ],
            [
                'messages' => [
                    Message::create(
                        Translation::create(
                            'other_message',
                            'Good morning!',
                            'en'
                        ),
                        new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458')
                    )
                ],
                'id_method' => 'getMessageId'
            ]
        ];
    }

    public function findAllProvider(): array
    {
        return [
            'by_catalogue_id' => [
                'criteria' => new QueryCriteria(
                    Message::class,
                    new FilterSet(['catalogue_id' => new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425')]),
                    new SortSet()
                ),
                'expected' => [
                    Message::restoreFrom(
                        new MessageId('0ec85c11-5153-4de9-b44c-442cb8f57a88'),
                        Translation::create(
                            'test.message.3',
                            'Hello from message #3 in language fr!',
                            'fr'
                        ),
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:23'),
                            Carbon::parse('2015-01-02 12:00:23'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('a9933d3c-d35f-482e-9b8a-3be629936f36'),
                        Translation::create(
                            'test.message.3',
                            'Hello from message #3 in language pl!',
                            'pl'
                        ),
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:22'),
                            Carbon::parse('2015-01-02 12:00:22'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('01892f4a-e15a-44b6-a3e8-03441d94d902'),
                        Translation::create(
                            'test.message.3',
                            'Hello from message #3 in language en!',
                            'en'
                        ),
                        new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:21'),
                            Carbon::parse('2015-01-02 12:00:21'),
                            true
                        )
                    )
                ]
            ],

            'disabled' => [
                'criteria' => new QueryCriteria(
                    Message::class,
                    new FilterSet(['enabled' => false]),
                    new SortSet()
                ),
                'expected' => [
                    Message::restoreFrom(
                        new MessageId('6ffa7d14-0b67-4420-9266-6d60228707c6'),
                        Translation::create(
                            'test.message.10',
                            'Hello from message #10 in language fr!',
                            'fr'
                        ),
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:20'),
                            Carbon::parse('2015-01-02 12:00:20'),
                            false
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('ec2adbdd-505d-4055-a081-124d38e8c70d'),
                        Translation::create(
                            'test.message.10',
                            'Hello from message #10 in language pl!',
                            'pl'
                        ),
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:10'),
                            Carbon::parse('2015-01-02 12:00:10'),
                            false
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('b5bce595-58d2-4023-89ab-df08b5c10e95'),
                        Translation::create(
                            'test.message.10',
                            'Hello from message #10 in language en!',
                            'en'
                        ),
                        new CatalogueId('8094de70-b269-4ea3-a11c-4d43a5218b23'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:00'),
                            Carbon::parse('2015-01-02 12:00:00'),
                            false
                        )
                    )
                ]
            ],

            'by_phrase_in_translation' => [
                'criteria' => new QueryCriteria(
                    Message::class,
                    new FilterSet(['phrase' => 'message #2']),
                    new SortSet()
                ),
                'expected' => [
                    Message::restoreFrom(
                        new MessageId('28cf1cb1-98b1-4ced-9d35-ba5a885886da'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language fr!',
                            'fr'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:26'),
                            Carbon::parse('2015-01-02 12:00:26'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('bdd09c50-cf76-44cf-a00a-984db2a17914'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language pl!',
                            'pl'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:25'),
                            Carbon::parse('2015-01-02 12:00:25'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('d1c70ed4-8d45-4b55-a2c6-3914726276b2'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language en!',
                            'en'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:24'),
                            Carbon::parse('2015-01-02 12:00:24'),
                            true
                        )
                    )
                ]
            ],

            'by_phrase_in_message_key' => [
                'criteria' => new QueryCriteria(
                    Message::class,
                    new FilterSet(['phrase' => 'message.2']),
                    new SortSet()
                ),
                'expected' => [
                    Message::restoreFrom(
                        new MessageId('28cf1cb1-98b1-4ced-9d35-ba5a885886da'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language fr!',
                            'fr'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:26'),
                            Carbon::parse('2015-01-02 12:00:26'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('bdd09c50-cf76-44cf-a00a-984db2a17914'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language pl!',
                            'pl'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:25'),
                            Carbon::parse('2015-01-02 12:00:25'),
                            true
                        )
                    ),
                    Message::restoreFrom(
                        new MessageId('d1c70ed4-8d45-4b55-a2c6-3914726276b2'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language en!',
                            'en'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:24'),
                            Carbon::parse('2015-01-02 12:00:24'),
                            true
                        )
                    )
                ]
            ],

            'by_language' => [
                'criteria' => new QueryCriteria(
                    Message::class,
                    new FilterSet(['language' => 'pl', 'phrase' => 'message.2']),
                    new SortSet()
                ),
                'expected' => [
                    Message::restoreFrom(
                        new MessageId('bdd09c50-cf76-44cf-a00a-984db2a17914'),
                        Translation::create(
                            'test.message.2',
                            'Hello from message #2 in language pl!',
                            'pl'
                        ),
                        new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                        Metadata::restoreFrom(
                            Carbon::parse('2015-01-01 12:00:25'),
                            Carbon::parse('2015-01-02 12:00:25'),
                            true
                        )
                    )
                ]
            ]
        ];
    }
}

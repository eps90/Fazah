<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\Catalogue\EditCatalogue;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class EditCatalogueTest extends SerializableCommandTest
{
    /**
     * @test
     */
    public function itShouldAssignCatalogueDataToProperty(): void
    {
        $catalogueData = [
            'name' => 'updated name',
            'alias' => 'updated-alias'
        ];
        $command = new EditCatalogue(CatalogueId::generate(), $catalogueData);

        static::assertEquals($catalogueData, $command->getCatalogueData());
    }

    /**
     * @test
     */
    public function itShouldThrowWhenDataHasRedundantValues(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $invalidData = [
            'name' => 'updated name',
            'redundant_value' => 'This one should throw'
        ];
        new EditCatalogue(CatalogueId::generate(), $invalidData);
    }

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'catalogue_id' => '742f5d72-2b7e-48a3-87ff-9f7f430d063a',
                    'catalogue_data' => [
                        'name' => 'Catalogue name',
                        'alias' => 'catalogue-name'
                    ]
                ],
                'expected' => new EditCatalogue(
                    new CatalogueId('742f5d72-2b7e-48a3-87ff-9f7f430d063a'),
                    [
                        'name' => 'Catalogue name',
                        'alias' => 'catalogue-name'
                    ]
                )
            ],
            [
                'props' => [
                    'catalogue_id' => '742f5d72-2b7e-48a3-87ff-9f7f430d063a',
                    'catalogue_data' => [
                        'alias' => 'catalogue-name'
                    ]
                ],
                'expected' => new EditCatalogue(
                    new CatalogueId('742f5d72-2b7e-48a3-87ff-9f7f430d063a'),
                    [
                        'alias' => 'catalogue-name'
                    ]
                )
            ],
            [
                'props' => [
                    'catalogue_id' => '742f5d72-2b7e-48a3-87ff-9f7f430d063a',
                    'catalogue_data' => [
                        'name' => 'Catalogue name'
                    ]
                ],
                'expected' => new EditCatalogue(
                    new CatalogueId('742f5d72-2b7e-48a3-87ff-9f7f430d063a'),
                    [
                        'name' => 'Catalogue name'
                    ]
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'catalogue_id' => '742f5d72-2b7e-48a3-87ff-9f7f430d063a',
                ]
            ],
            [
                'props' => [
                    'catalogue_data' => [
                        'name' => 'Catalogue name',
                        'alias' => 'catalogue-name'
                    ]
                ]
            ],
            [
                'props' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return EditCatalogue::class;
    }
}

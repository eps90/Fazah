<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\UseCase\Command\Catalogue\CreateCatalogue;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class CreateCatalogueTest extends SerializableCommandTest
{
    /**
     * @test
     */
    public function itShouldBeAbleToCreateItFromArray(): void
    {
        $inputProps = [
            'name' => 'My catalogue',
            'project_id' => 'f2962b5d-ae24-4314-8a26-592c383e8884',
            'parent_catalogue_id' => '421772af-9294-48bf-a003-17d9e484ba2a'
        ];
        $actualCommand = CreateCatalogue::fromArray($inputProps);
        $expectedCommand = new CreateCatalogue(
            'My catalogue',
            new ProjectId('f2962b5d-ae24-4314-8a26-592c383e8884'),
            new CatalogueId('421772af-9294-48bf-a003-17d9e484ba2a')
        );

        static::assertEquals($expectedCommand, $actualCommand);
    }

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'name' => 'My catalogue',
                    'project_id' => 'f2962b5d-ae24-4314-8a26-592c383e8884',
                    'parent_catalogue_id' => '421772af-9294-48bf-a003-17d9e484ba2a'
                ],
                'expected' => new CreateCatalogue(
                    'My catalogue',
                    new ProjectId('f2962b5d-ae24-4314-8a26-592c383e8884'),
                    new CatalogueId('421772af-9294-48bf-a003-17d9e484ba2a')
                )
            ],
            [
                'props' => [
                    'name' => 'My catalogue',
                    'project_id' => 'f2962b5d-ae24-4314-8a26-592c383e8884'
                ],
                'expected' => new CreateCatalogue(
                    'My catalogue',
                    new ProjectId('f2962b5d-ae24-4314-8a26-592c383e8884'),
                    null
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'project_id' => 'f2962b5d-ae24-4314-8a26-592c383e8884',
                    'parent_catalogue_id' => '421772af-9294-48bf-a003-17d9e484ba2a'
                ]
            ],
            [
                'props' => [
                    'name' => 'My catalogue',
                    'parent_catalogue_id' => '421772af-9294-48bf-a003-17d9e484ba2a'
                ]
            ],
            [
                'props' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return CreateCatalogue::class;
    }
}

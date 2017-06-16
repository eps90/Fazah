<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\Catalogue\ChangeCatalogueState;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;

class ChangeCatalogueStateTest extends SerializableCommandTest
{

    public function validInputProperties(): array
    {
        return [
            [
                'props' => [
                    'catalogue_id' => '968e2ed5-86c0-47f5-8f96-b2f3e198bf50',
                    'enabled' => true
                ],
                'expected' => new ChangeCatalogueState(
                    new CatalogueId('968e2ed5-86c0-47f5-8f96-b2f3e198bf50'),
                    true
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'props' => [
                    'enabled' => true
                ]
            ],
            [
                'props' => [
                    'catalogue_id' => '968e2ed5-86c0-47f5-8f96-b2f3e198bf50'
                ]
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return ChangeCatalogueState::class;
    }
}

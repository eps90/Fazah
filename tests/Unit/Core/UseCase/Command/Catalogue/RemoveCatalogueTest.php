<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\Catalogue\RemoveCatalogue;
use Eps\Fazah\Tests\Unit\Core\UseCase\Command\SerializableCommandTest;
use PHPUnit\Framework\TestCase;

class RemoveCatalogueTest extends SerializableCommandTest
{
    public function validInputProperties(): array
    {
        return [
            [
                'input' => [
                    'catalogue_id' => '6915f1a9-64db-4c73-bbed-324c5c5b558e'
                ],
                'expected' => new RemoveCatalogue(
                    new CatalogueId('6915f1a9-64db-4c73-bbed-324c5c5b558e')
                )
            ]
        ];
    }

    public function invalidInputProperties(): array
    {
        return [
            [
                'input' => []
            ]
        ];
    }

    public function getCommandClass(): string
    {
        return RemoveCatalogue::class;
    }
}

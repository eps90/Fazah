<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\EditCatalogue;
use PHPUnit\Framework\TestCase;

class EditCatalogueTest extends TestCase
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
}

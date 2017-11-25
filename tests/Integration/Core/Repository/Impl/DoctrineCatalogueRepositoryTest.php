<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\CatalogueRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineCatalogueRepositoryTest extends DoctrineRepositoryTest
{
    use CatalogueRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        return $this->getContainer()->get('fazah.repository.catalogue');
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class,
            AddCatalogues::class
        ];
    }
    
    /**
     * @test
     * @dataProvider removeProvider
     */
    public function itShouldBeAbleToRemoveACatalogue(CatalogueId $catalogueId, array $expectedCatalogues): void
    {
        $repository = $this->getRepositoryInstance();
        $repository->remove($catalogueId);
        
        $actualCatalogues = $repository->findAll();
        
        static::assertEquals($expectedCatalogues, $actualCatalogues);
    }
}

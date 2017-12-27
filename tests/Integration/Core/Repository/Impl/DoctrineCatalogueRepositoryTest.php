<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\CatalogueRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineCatalogueRepositoryTest extends DoctrineRepositoryTest
{
    use CatalogueRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        return $this->getContainer()->get('test.fazah.repository.catalogue');
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class,
            AddCatalogues::class
        ];
    }
}

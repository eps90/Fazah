<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Repository\Impl\DoctrineCatalogueRepository;
use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\CatalogueRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineCatalogueRepositoryTest extends DoctrineRepositoryTest
{
    use CatalogueRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $matcher = $container->get('fazah.query.criteria_matcher');

        return new DoctrineCatalogueRepository($entityManager, $matcher);
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class,
            AddCatalogues::class
        ];
    }
}

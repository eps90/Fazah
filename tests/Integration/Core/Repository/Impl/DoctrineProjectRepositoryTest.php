<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Repository\Impl\DoctrineProjectRepository;
use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\ProjectRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineProjectRepositoryTest extends DoctrineRepositoryTest
{
    use ProjectRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $matcher = $container->get('fazah.query.criteria_matcher');

        return new DoctrineProjectRepository($entityManager, $matcher);
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class
        ];
    }
}

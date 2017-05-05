<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Repository\Impl\DoctrineMessageRepository;
use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\MessageRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineMessageRepositoryTest extends DoctrineRepositoryTest
{
    use MessageRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $matcher = $container->get('fazah.query.criteria_matcher');

        return new DoctrineMessageRepository($entityManager, $matcher);
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class,
            AddCatalogues::class,
            AddMessages::class
        ];
    }
}

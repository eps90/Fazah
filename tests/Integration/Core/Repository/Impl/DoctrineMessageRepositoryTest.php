<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\MessageRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineMessageRepositoryTest extends DoctrineRepositoryTest
{
    use MessageRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        return $this->getContainer()->get('fazah.repository.message');
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

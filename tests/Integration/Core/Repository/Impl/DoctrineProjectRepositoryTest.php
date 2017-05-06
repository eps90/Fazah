<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Tests\Integration\Core\Repository\Impl\DataProvider\ProjectRepositoryDataProvider;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;

class DoctrineProjectRepositoryTest extends DoctrineRepositoryTest
{
    use ProjectRepositoryDataProvider;

    public function getRepositoryInstance()
    {
        return $this->getContainer()->get('fazah.repository.project');
    }

    public function getRepositoryFixtures(): array
    {
        return [
            AddProjects::class
        ];
    }
}

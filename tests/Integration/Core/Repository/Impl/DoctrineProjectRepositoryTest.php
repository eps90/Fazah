<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Identity\Identity;
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

    /**
     * @test
     * @dataProvider removeProvider
     */
    public function itShouldBeAbleToRemoveProject(Identity $projectId, array $expected): void
    {
        $repository = $this->getRepositoryInstance();
        $repository->remove($projectId);

        $actualProjects = $repository->findAll();

        static::assertEquals($expected, $actualProjects);
    }
}

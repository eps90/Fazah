<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Integration\Core\Repository;

use Carbon\Carbon;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\DoctrineCatalogueRepository;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Tests\Resources\Fixtures\AddCatalogues;
use Eps\Fazah\Tests\Resources\Fixtures\AddMessages;
use Eps\Fazah\Tests\Resources\Fixtures\AddProjects;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class DoctrineCatalogueRepositoryTest extends WebTestCase
{
    /**
     * @var DoctrineCatalogueRepository
     */
    private $repository;

    protected function setUp()
    {
        parent::setUp();

        $container = $this->getContainer();
        $entityManager = $container->get('doctrine.orm.entity_manager');
        $this->repository = new DoctrineCatalogueRepository($entityManager);

        $this->loadFixtures([
            AddProjects::class,
            AddCatalogues::class,
            AddMessages::class
        ]);
    }

    /**
     * @test
     */
    public function itShouldFindCatalogueByCatalogueId(): void
    {
        $catalogueId = new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425');

        $expectedCatalogue = Catalogue::restoreFrom(
            $catalogueId,
            'second-catalogue',
            Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
            true,
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260')
        );
        $actualCatalogue = $this->repository->find($catalogueId);

        static::assertEquals($expectedCatalogue, $actualCatalogue);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenCatalogueWithGivenIdDoesNotExist(): void
    {
        $this->expectException(CatalogueRepositoryException::class);

        $missingCatalogueId = CatalogueId::generate();

        $this->repository->find($missingCatalogueId);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddNewCatalogue(): void
    {
        $newCatalogue = Catalogue::restoreFrom(
            CatalogueId::generate(),
            'second-catalogue',
            Carbon::instance(new \DateTime('2017-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2017-01-02 12:00:01')),
            true,
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260')
        );
        $this->repository->add($newCatalogue);

        $expectedCatalogue = $newCatalogue;
        $actualCatalogue = $this->repository->find($newCatalogue->getCatalogueId());

        static::assertEquals($expectedCatalogue, $actualCatalogue);
    }

    /**
     * @test
     */
    public function itShouldThrowWhenCatalogueAlreadyExists(): void
    {
        $this->expectException(CatalogueRepositoryException::class);

        $duplicatedCatId = new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425');
        $duplicatedCatalogue = Catalogue::restoreFrom(
            $duplicatedCatId,
            'second-catalogue',
            Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
            Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
            true,
            new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260')
        );

        $this->repository->add($duplicatedCatalogue);
    }

    /**
     * @test
     */
    public function itShouldBeAbleToFindAllCataloguesByProjectId(): void
    {
        $projectId = new ProjectId('a558d385-a0b4-4f0d-861c-da6b9cd83260');
        $expectedCatalogues = [
            Catalogue::restoreFrom(
                new CatalogueId('b21deaae-8078-45e7-a83c-47a72e8d0458'),
                'third-catalogue',
                Carbon::instance(new \DateTime('2015-01-01 12:00:02')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:02')),
                true,
                $projectId
            ),
            Catalogue::restoreFrom(
                new CatalogueId('3df07fa8-80fa-4d5d-a0cb-9bcf3d830425'),
                'second-catalogue',
                Carbon::instance(new \DateTime('2015-01-01 12:00:01')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:01')),
                true,
                $projectId
            ),
            Catalogue::restoreFrom(
                new CatalogueId('a853f467-403d-416b-8269-36369c34d723'),
                'first-catalogue',
                Carbon::instance(new \DateTime('2015-01-01 12:00:00')),
                Carbon::instance(new \DateTime('2015-01-02 12:00:00')),
                true,
                $projectId
            )
        ];
        $actualCatalogues = $this->repository->findByProjectId($projectId);

        static::assertEquals($expectedCatalogues, $actualCatalogues);
    }
}

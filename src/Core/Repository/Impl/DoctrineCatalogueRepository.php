<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Core\Repository\Query\CriteriaMatcher;
use Eps\Fazah\Core\Repository\Query\Filtering\FilterSet;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Eps\Fazah\Core\Repository\Query\Sorting\SortSet;

final class DoctrineCatalogueRepository implements CatalogueRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var CriteriaMatcher
     */
    private $matcher;

    public function __construct(EntityManagerInterface $entityManager, CriteriaMatcher $matcher)
    {
        $this->entityManager = $entityManager;
        $this->matcher = $matcher;
    }

    /**
     * {@inheritdoc}
     */
    public function save(Catalogue ...$catalogues): void
    {
        foreach ($catalogues as $catalogue) {
            $this->entityManager->persist($catalogue);
        }

        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function find(CatalogueId $catalogueId): Catalogue
    {
        $catalogue = $this->entityManager->find(Catalogue::class, $catalogueId);
        if ($catalogue === null) {
            throw CatalogueRepositoryException::notFound($catalogueId);
        }

        return $catalogue;
    }

    /**
     * {@inheritdoc}
     */
    public function findByProjectId(ProjectId $projectId): array
    {
        return $this->entityManager->createQuery(
            'SELECT cat FROM Fazah:Catalogue cat 
            WHERE cat.projectId = :projectId
            ORDER BY cat.metadata.createdAt DESC, cat.metadata.updatedAt DESC'
        )
            ->setParameter('projectId', $projectId)
            ->getResult();
    }

    /**
     * {@inheritdoc}
     */
    public function findAll(QueryCriteria $criteria = null): array
    {
        if ($criteria === null) {
            $criteria = new QueryCriteria(Catalogue::class, new FilterSet(), new SortSet());
        }

        return $this->matcher->match($criteria);
    }
}

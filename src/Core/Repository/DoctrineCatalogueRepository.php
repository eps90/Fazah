<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;

final class DoctrineCatalogueRepository implements CatalogueRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function add(Catalogue ...$catalogues): void
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
            ORDER BY cat.createdAt DESC, cat.updatedAt DESC'
        )
            ->setParameter('projectId', $projectId)
            ->getResult();
    }
}

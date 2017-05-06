<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository\Impl;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;

final class DoctrineCatalogueRepository extends BaseDoctrineRepository implements CatalogueRepository
{
    /**
     * {@inheritdoc}
     */
    public function save(Catalogue ...$catalogues): void
    {
        $this->saveAll($catalogues);
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

    protected function getModelClass(): string
    {
        return Catalogue::class;
    }
}

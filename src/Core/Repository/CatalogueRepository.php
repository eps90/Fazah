<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;

interface CatalogueRepository
{
    /**
     * @param Catalogue[] ...$catalogues
     */
    public function add(Catalogue ...$catalogues): void;

    /**
     * @param CatalogueId $catalogueId
     * @return Catalogue
     * @throws CatalogueRepositoryException
     */
    public function find(CatalogueId $catalogueId): Catalogue;

    /**
     * @param ProjectId $projectId
     * @return Catalogue[]
     */
    public function findByProjectId(ProjectId $projectId): array;
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Model\Identity\ProjectId;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;

interface CatalogueRepository
{
    /**
     * @param Catalogue[] ...$catalogues
     */
    public function save(Catalogue ...$catalogues): void;

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

    /**
     * @param QueryCriteria|null $criteria
     * @return Catalogue[]
     */
    public function findAll(QueryCriteria $criteria = null): array;
}

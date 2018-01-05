<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\Repository;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\Repository\Exception\CatalogueRepositoryException;
use Eps\Fazah\Core\Repository\Query\QueryCriteria;
use Porpaginas\Result;

interface CatalogueRepository extends RepositoryInterface
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
     * @param QueryCriteria|null $criteria
     * @return Result|Catalogue[]
     */
    public function findAll(QueryCriteria $criteria = null): Result;

    public function remove(CatalogueId $catalogueId): void;
}

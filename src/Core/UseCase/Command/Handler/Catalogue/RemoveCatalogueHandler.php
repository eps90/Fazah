<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\RemoveCatalogue;

class RemoveCatalogueHandler
{
    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    public function __construct(CatalogueRepository $catalogueRepo)
    {
        $this->catalogueRepo = $catalogueRepo;
    }

    public function handle(RemoveCatalogue $command): void
    {
        $this->catalogueRepo->remove($command->getCatalogueId());
    }
}

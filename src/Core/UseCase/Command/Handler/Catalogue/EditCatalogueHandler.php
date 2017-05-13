<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\EditCatalogue;

class EditCatalogueHandler
{
    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    public function __construct(CatalogueRepository $catalogueRepo)
    {
        $this->catalogueRepo = $catalogueRepo;
    }

    public function handle(EditCatalogue $command): void
    {
        $catalogueId = $command->getCatalogueId();
        $catalogueData = $command->getCatalogueData();

        $catalogue = $this->catalogueRepo->find($catalogueId);
        $catalogue->updateFromArray($catalogueData);
        $this->catalogueRepo->save($catalogue);
    }
}

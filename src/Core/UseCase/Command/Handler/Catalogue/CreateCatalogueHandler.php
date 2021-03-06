<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler\Catalogue;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\Catalogue\CreateCatalogue;

class CreateCatalogueHandler
{
    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    public function __construct(CatalogueRepository $catalogueRepo)
    {
        $this->catalogueRepo = $catalogueRepo;
    }

    public function handle(CreateCatalogue $command): void
    {
        $catalogue = Catalogue::create($command->getName(), $command->getProjectId(), $command->getParentCatalogueId());
        $this->catalogueRepo->save($catalogue);
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Handler;

use Eps\Fazah\Core\Repository\CatalogueRepository;
use Eps\Fazah\Core\UseCase\Command\ChangeCatalogueState;

class ChangeCatalogueStateHandler
{
    /**
     * @var CatalogueRepository
     */
    private $catalogueRepo;

    public function __construct(CatalogueRepository $catalogueRepo)
    {
        $this->catalogueRepo = $catalogueRepo;
    }

    public function handle(ChangeCatalogueState $command): void
    {
        $catalogue = $this->catalogueRepo->find($command->getCatalogueId());
        if ($command->shouldBeEnabled()) {
            $catalogue->enable();
        } else {
            $catalogue->disable();
        }

        $this->catalogueRepo->save($catalogue);
    }
}

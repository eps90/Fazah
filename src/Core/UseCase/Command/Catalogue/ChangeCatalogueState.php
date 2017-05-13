<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;

final class ChangeCatalogueState
{
    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var bool
     */
    private $shouldBeEnabled;

    public function __construct(CatalogueId $catalogueId, bool $shouldBeEnabled)
    {
        $this->catalogueId = $catalogueId;
        $this->shouldBeEnabled = $shouldBeEnabled;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    /**
     * @return bool
     */
    public function shouldBeEnabled(): bool
    {
        return $this->shouldBeEnabled;
    }
}

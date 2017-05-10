<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\CatalogueId;

final class AddMessage
{
    /**
     * @var string
     */
    private $messageKey;

    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * AddMessage constructor.
     * @param string $messageKey
     * @param CatalogueId $catalogueId
     */
    public function __construct($messageKey, CatalogueId $catalogueId)
    {
        $this->messageKey = $messageKey;
        $this->catalogueId = $catalogueId;
    }

    /**
     * @return string
     */
    public function getMessageKey(): string
    {
        return $this->messageKey;
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }
}

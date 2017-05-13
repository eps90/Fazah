<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditCatalogue
{
    /**
     * @var CatalogueId
     */
    private $catalogueId;

    /**
     * @var array
     */
    private $catalogueData;

    public function __construct(CatalogueId $catalogueId, array $catalogueData)
    {
        $this->catalogueId = $catalogueId;
        $this->catalogueData = $this->resolveOptions($catalogueData);
    }

    /**
     * @return CatalogueId
     */
    public function getCatalogueId(): CatalogueId
    {
        return $this->catalogueId;
    }

    /**
     * @return array
     */
    public function getCatalogueData(): array
    {
        return $this->catalogueData;
    }

    private function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['name', 'alias']);

        return $resolver->resolve($properties);
    }
}

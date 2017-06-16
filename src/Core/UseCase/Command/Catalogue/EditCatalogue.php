<?php
declare(strict_types=1);

namespace Eps\Fazah\Core\UseCase\Command\Catalogue;

use Eps\Fazah\Core\Model\Identity\CatalogueId;
use Eps\Fazah\Core\UseCase\Command\SerializableCommand;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class EditCatalogue implements SerializableCommand
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
        $this->catalogueData = self::resolveOptions($catalogueData);
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

    public static function fromArray(array $commandProps): self
    {
        $resolver = new OptionsResolver();
        $resolver->setRequired(['catalogue_id', 'catalogue_data']);
        $props = $resolver->resolve($commandProps);

        $catalogueData = self::resolveOptions($props['catalogue_data']);

        return new self(
            new CatalogueId((string)$props['catalogue_id']),
            $catalogueData
        );
    }

    private static function resolveOptions(array $properties): array
    {
        $resolver = new OptionsResolver();
        $resolver->setDefined(['name', 'alias']);

        return $resolver->resolve($properties);
    }
}

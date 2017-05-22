<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter;

use Eps\Fazah\Core\Model\Catalogue;

final class CatalogueFilter implements FilterInterface
{

    /**
     * {@inheritdoc}
     */
    public function getAvailableFilters(): array
    {
        return [
            'project_id',
            'enabled',
            'phrase'
        ];
    }

    public function supportsResource(string $resourceClass): bool
    {
        return $resourceClass === Catalogue::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'project_id' => [
                'property' => 'project_id',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Project that catalogue belongs to'
                ]
            ],
            'enabled' => [
                'property' => 'enabled',
                'type' => 'bool',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by enabled/disabled state'
                ]
            ],
            'phrase' => [
                'property' => 'phrase',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by containing phrase'
                ]
            ]
        ];
    }
}

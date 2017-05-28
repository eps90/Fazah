<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter;

use Eps\Fazah\Core\Model\Project;

final class ProjectFilter implements FilterInterface
{
    /**
     * @return string[]
     */
    public function getAvailableFilters(): array
    {
        return [
            'enabled',
            'phrase'
        ];
    }

    public function supportsResource(string $resourceClass): bool
    {
        return Project::class === $resourceClass;
    }

    /**
     * {@inheritdoc}
     * @codeCoverageIgnore
     */
    public function getDescription(string $resourceClass): array
    {
        return [
            'enabled' => [
                'property' => 'enabled',
                'type' => 'bool',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by disabled/enabled state'
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

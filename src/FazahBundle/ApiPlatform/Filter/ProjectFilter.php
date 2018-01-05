<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter;

use Eps\Fazah\Core\Model\Project;

final class ProjectFilter implements FilterInterface
{
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
            ],
            'limit' => [
                'property' => 'limit',
                'type' => 'integer',
                'required' => false,
                'swagger' => [
                    'description' => 'Limit response by given size'
                ]
            ]
        ];
    }
}

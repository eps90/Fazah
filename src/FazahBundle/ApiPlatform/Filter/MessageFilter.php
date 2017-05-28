<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\ApiPlatform\Filter;

use Eps\Fazah\Core\Model\Message;

final class MessageFilter implements FilterInterface
{

    /**
     * {@inheritdoc}
     */
    public function getAvailableFilters(): array
    {
        return [
            'enabled',
            'phrase',
            'catalogue_id',
            'language'
        ];
    }

    public function supportsResource(string $resourceClass): bool
    {
        return $resourceClass === Message::class;
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
            'catalogue_id' => [
                'property' => 'catalogue_id',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Catalogue that message belongs to'
                ]
            ],
            'language' => [
                'property' => 'language',
                'type' => 'string',
                'required' => false,
                'swagger' => [
                    'description' => 'Filter by message\'s language'
                ]
            ]
        ];
    }
}

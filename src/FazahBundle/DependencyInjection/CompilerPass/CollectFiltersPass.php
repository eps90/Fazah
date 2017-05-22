<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CollectFiltersPass implements CompilerPassInterface
{
    public const FILTERS_SERVICE = 'fazah.api.filters';
    public const FILTER_TAG = 'fazah.api.filter';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::FILTERS_SERVICE)) {
            return;
        }

        $filtersDefinition = $container->findDefinition(self::FILTERS_SERVICE);
        $filterIds = array_keys($container->findTaggedServiceIds(self::FILTER_TAG));
        $filterReferences = array_map(
            function (string $filterName) {
                return new Reference($filterName);
            },
            $filterIds
        );
        $filtersDefinition->setArguments([$filterReferences]);
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class AddQueryCriteriaPass implements CompilerPassInterface
{
    public const CRITERIA_MATCHER_SVC_ID = 'fazah.query.criteria_matcher';
    public const CONDITION_BUILDER_TAG = 'fazah.condition_builder';
    private const DEFAULT_PRIORITY = 0;

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(self::CRITERIA_MATCHER_SVC_ID)) {
            return;
        }

        $criteriaMatcher = $container->findDefinition(self::CRITERIA_MATCHER_SVC_ID);
        $builders = $container->findTaggedServiceIds(self::CONDITION_BUILDER_TAG);

        $queue = new \SplPriorityQueue();
        foreach ($builders as $serviceId => $builderTags) {
            foreach ($builderTags as $tag) {
                $priority = array_key_exists('priority', $tag)
                    ? $tag['priority']
                    : self::DEFAULT_PRIORITY;

                $queue->insert($serviceId, $priority);
            }
        }

        foreach ($queue as $serviceId) {
            $criteriaMatcher->addMethodCall('addBuilder', [new Reference($serviceId)]);
        }
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class CollectFilterProcessorsPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public const COLLECTING_SVC_ID = 'fazah.api.filter_processors';
    public const PROCESSOR_TAG = 'fazah.api.filter_processor';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::COLLECTING_SVC_ID)) {
            return;
        }

        $collectingService = $container->findDefinition(self::COLLECTING_SVC_ID);
        $processorsIds = $this->findAndSortTaggedServices(self::PROCESSOR_TAG, $container);
        $collectingService->setArguments([$processorsIds]);
    }
}

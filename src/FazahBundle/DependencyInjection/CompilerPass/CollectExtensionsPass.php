<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class CollectExtensionsPass implements CompilerPassInterface
{
    public const EXTENSION_SERVICE = 'fazah.api.extensions';
    public const EXTENSION_TAG = 'fazah.api.extension';

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(self::EXTENSION_SERVICE)) {
            return;
        }

        $extensionsDefinition = $container->findDefinition(self::EXTENSION_SERVICE);
        $extensionsIds = array_keys($container->findTaggedServiceIds(self::EXTENSION_TAG));
        $extensionsReferences = array_map(
            function (string $extensionId) {
                return new Reference($extensionId);
            },
            $extensionsIds
        );

        $extensionsDefinition->setArguments([$extensionsReferences]);
    }
}

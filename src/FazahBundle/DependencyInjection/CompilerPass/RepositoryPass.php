<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RepositoryPass implements CompilerPassInterface
{
    public const MANAGER_SVC_ID = 'fazah.repository_manager';
    public const REPO_TAG = 'fazah.repository';

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(self::MANAGER_SVC_ID)) {
            return;
        }

        $managerDefinition = $container->findDefinition(self::MANAGER_SVC_ID);
        $repositories = $container->findTaggedServiceIds(self::REPO_TAG);

        foreach ($repositories as $id => $tags) {
            foreach ($tags as $tag) {
                if (!isset($tag['model'])) {
                    throw new \InvalidArgumentException(
                        'Repository must have model class configured with \'model\' property!'
                    );
                }
                $managerDefinition->addMethodCall(
                    'addRepository',
                    [$tag['model'], new Reference($id)]
                );
            }
        }
    }
}

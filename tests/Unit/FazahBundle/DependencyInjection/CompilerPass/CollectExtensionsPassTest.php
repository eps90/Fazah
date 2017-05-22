<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\DependencyInjection\CompilerPass;

use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\CollectExtensionsPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CollectExtensionsPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CollectExtensionsPass());
    }

    /**
     * @test
     */
    public function itShouldCollectExtensions(): void
    {
        $collectingService = new Definition();
        $this->setDefinition(CollectExtensionsPass::EXTENSION_SERVICE, $collectingService);

        $firstExtension = new Definition();
        $firstExtension->addTag(CollectExtensionsPass::EXTENSION_TAG);
        $this->setDefinition('extensions.one', $firstExtension);

        $otherExtension = new Definition();
        $otherExtension->addTag(CollectExtensionsPass::EXTENSION_TAG);
        $this->setDefinition('extensions.two', $otherExtension);

        $this->compile();

        $extensionsService = $this->container->getDefinition(CollectExtensionsPass::EXTENSION_SERVICE);

        $expectedArgs = [[new Reference('extensions.one'), new Reference('extensions.two')]];
        $actualArgs = $extensionsService->getArguments();

        static::assertEquals($expectedArgs, $actualArgs);
    }
}

<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\DependencyInjection\CompilerPass;

use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\CollectModelFiltersPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CollectFiltersPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CollectModelFiltersPass());
    }

    /**
     * @test
     */
    public function itShouldCollectAllFiltersIntoSingleService(): void
    {
        $collectingService = new Definition();
        $this->setDefinition(CollectModelFiltersPass::FILTERS_SERVICE, $collectingService);

        $firstFilter = new Definition();
        $firstFilter->addTag(CollectModelFiltersPass::FILTER_TAG);
        $this->setDefinition('filter.one', $firstFilter);

        $otherFilter = new Definition();
        $otherFilter->addTag(CollectModelFiltersPass::FILTER_TAG);
        $this->setDefinition('filter.two', $otherFilter);

        $this->compile();

        $filtersDefinition = $this->container->getDefinition(CollectModelFiltersPass::FILTERS_SERVICE);

        $expectedArguments = [[new Reference('filter.one'), new Reference('filter.two')]];
        $actualArguments = $filtersDefinition->getArguments();

        static::assertEquals($expectedArguments, $actualArguments);
    }
}

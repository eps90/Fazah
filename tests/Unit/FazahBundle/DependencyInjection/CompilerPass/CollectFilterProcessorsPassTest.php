<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\DependencyInjection\CompilerPass;

use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\CollectFilterProcessorsPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class CollectFilterProcessorsPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new CollectFilterProcessorsPass());
    }

    /**
     * @test
     */
    public function itShouldCollectFilterProcessors(): void
    {
        $collectingService = new Definition();
        $this->setDefinition('fazah.api.filter_processors', $collectingService);

        $filterProcessorOne = new Definition();
        $filterProcessorOne->addTag('fazah.api.filter_processor');
        $this->setDefinition('fazah.api.processor_1', $filterProcessorOne);

        $filterProcessorTwo = new Definition();
        $filterProcessorTwo->addTag('fazah.api.filter_processor');
        $this->setDefinition('fazah.api.processor_2', $filterProcessorTwo);

        $nonRelatedService = new Definition();
        $this->setDefinition('fazah.api.processor_3', $nonRelatedService);

        $this->compile();

        $expectedProcessors = [
            new Reference('fazah.api.processor_1'),
            new Reference('fazah.api.processor_2')
        ];

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'fazah.api.filter_processors',
            0,
            $expectedProcessors
        );
    }

    /**
     * @test
     */
    public function itShouldSortProcessorsByPriority(): void
    {
        $collectingService = new Definition();
        $this->setDefinition('fazah.api.filter_processors', $collectingService);

        $filterProcessorOne = new Definition();
        $filterProcessorOne->addTag('fazah.api.filter_processor', ['priority' => -1]);
        $this->setDefinition('fazah.api.processor_1', $filterProcessorOne);

        $filterProcessorTwo = new Definition();
        $filterProcessorTwo->addTag('fazah.api.filter_processor', ['priority' => 1]);
        $this->setDefinition('fazah.api.processor_2', $filterProcessorTwo);

        $filterProcessorThree = new Definition();
        $filterProcessorThree->addTag('fazah.api.filter_processor', ['priority' => 2]);
        $this->setDefinition('fazah.api.processor_3', $filterProcessorThree);

        $this->compile();

        $expectedProcessors = [
            new Reference('fazah.api.processor_3'),
            new Reference('fazah.api.processor_2'),
            new Reference('fazah.api.processor_1')
        ];

        $this->assertContainerBuilderHasServiceDefinitionWithArgument(
            'fazah.api.filter_processors',
            0,
            $expectedProcessors
        );
    }
}

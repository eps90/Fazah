<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\DependencyInjection\CompilerPass;

use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\AddQueryCriteriaPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class AddQueryCriteriaPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new AddQueryCriteriaPass());
    }

    /**
     * @test
     */
    public function itShouldAddBuildersToDoctrineCriteriaMatcher(): void
    {
        $criteriaMatcher = new Definition();
        $this->setDefinition(AddQueryCriteriaPass::CRITERIA_MATCHER_SVC_ID, $criteriaMatcher);

        $builderOne = new Definition();
        $builderOne->addTag(AddQueryCriteriaPass::CONDITION_BUILDER_TAG);
        $this->setDefinition('fazah.builder.one', $builderOne);
        $builderTwo = new Definition();
        $builderTwo->addTag(AddQueryCriteriaPass::CONDITION_BUILDER_TAG);
        $this->setDefinition('fazah.builder.two', $builderTwo);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            AddQueryCriteriaPass::CRITERIA_MATCHER_SVC_ID,
            'addBuilder',
            [new Reference('fazah.builder.one')]
        );
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            AddQueryCriteriaPass::CRITERIA_MATCHER_SVC_ID,
            'addBuilder',
            [new Reference('fazah.builder.two')]
        );
    }

    /**
     * @test
     */
    public function itShouldSortTaggedServicesByPriority(): void
    {
        $criteriaMatcher = new Definition();
        $this->setDefinition(AddQueryCriteriaPass::CRITERIA_MATCHER_SVC_ID, $criteriaMatcher);

        $builderOne = new Definition();
        $builderOne->addTag(
            AddQueryCriteriaPass::CONDITION_BUILDER_TAG,
            ['priority' => 1]
        );
        $this->setDefinition('fazah.builder.one', $builderOne);

        $builderTwo = new Definition();
        $builderTwo->addTag(
            AddQueryCriteriaPass::CONDITION_BUILDER_TAG,
            ['priority' => 2]
        );
        $this->setDefinition('fazah.builder.two', $builderTwo);

        $this->compile();

        $expectedCalls = [
            [
                'addBuilder',
                [new Reference('fazah.builder.two')]
            ],
            [
                'addBuilder',
                [new Reference('fazah.builder.one')]
            ]
        ];
        $actualCalls = $criteriaMatcher->getMethodCalls();

        static::assertEquals($expectedCalls, $actualCalls);
    }
}

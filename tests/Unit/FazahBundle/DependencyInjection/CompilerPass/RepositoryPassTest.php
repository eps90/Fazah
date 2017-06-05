<?php
declare(strict_types=1);

namespace Eps\Fazah\Tests\Unit\FazahBundle\DependencyInjection\CompilerPass;

use Eps\Fazah\Core\Model\Catalogue;
use Eps\Fazah\Core\Model\Message;
use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\RepositoryPass;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class RepositoryPassTest extends AbstractCompilerPassTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function registerCompilerPass(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RepositoryPass());
    }

    /**
     * @test
     */
    public function itShouldCollectAllTaggedRepositories(): void
    {
        $managerService = new Definition();
        $this->setDefinition(RepositoryPass::MANAGER_SVC_ID, $managerService);

        $repository = new Definition();
        $repository->addTag(RepositoryPass::REPO_TAG, ['model' => Message::class]);
        $this->setDefinition('fazah.repo.one', $repository);

        $otherRepo = new Definition();
        $otherRepo->addTag(RepositoryPass::REPO_TAG, ['model' => Catalogue::class]);
        $this->setDefinition('fazah.repo.two', $otherRepo);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            RepositoryPass::MANAGER_SVC_ID,
            'addRepository',
            [Message::class, new Reference('fazah.repo.one')]
        );
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            RepositoryPass::MANAGER_SVC_ID,
            'addRepository',
            [Catalogue::class, new Reference('fazah.repo.two')]
        );
    }

    /**
     * @test
     */
    public function itShouldBeAbleToAddSameRepoToMultipleModels(): void
    {
        $managerService = new Definition();
        $this->setDefinition(RepositoryPass::MANAGER_SVC_ID, $managerService);

        $multiRepo = new Definition();
        $multiRepo->addTag(RepositoryPass::REPO_TAG, ['model' => Message::class]);
        $multiRepo->addTag(RepositoryPass::REPO_TAG, ['model' => Catalogue::class]);
        $this->setDefinition('fazah.repo.one', $multiRepo);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            RepositoryPass::MANAGER_SVC_ID,
            'addRepository',
            [Message::class, new Reference('fazah.repo.one')]
        );
        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall(
            RepositoryPass::MANAGER_SVC_ID,
            'addRepository',
            [Catalogue::class, new Reference('fazah.repo.one')]
        );
    }

    /**
     * @test
     */
    public function itShouldThrowWhenTagHasNoModelClass(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $managerService = new Definition();
        $this->setDefinition(RepositoryPass::MANAGER_SVC_ID, $managerService);

        $invalidRepo = new Definition();
        $invalidRepo->addTag(RepositoryPass::REPO_TAG);
        $this->setDefinition('fazah.repo.one', $invalidRepo);

        $this->compile();
    }
}

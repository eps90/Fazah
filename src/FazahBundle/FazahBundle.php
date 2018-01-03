<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle;

use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\AddQueryCriteriaPass;
use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\CollectExtensionsPass;
use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\CollectModelFiltersPass;
use Eps\Fazah\FazahBundle\DependencyInjection\CompilerPass\RepositoryPass;
use Eps\Fazah\FazahBundle\DependencyInjection\FazahExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FazahBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new AddQueryCriteriaPass());
        $container->addCompilerPass(new CollectModelFiltersPass());
        $container->addCompilerPass(new CollectExtensionsPass());
        $container->addCompilerPass(new RepositoryPass());
    }

    public function getContainerExtension()
    {
        return new FazahExtension();
    }
}

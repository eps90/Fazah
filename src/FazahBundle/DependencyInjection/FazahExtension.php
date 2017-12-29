<?php
declare(strict_types=1);

namespace Eps\Fazah\FazahBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class FazahExtension extends Extension
{

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config/services')
        );
        $loader->load('query.xml');
        $loader->load('repositories.xml');
        $loader->load('commands.xml');
        $loader->load('api.xml');

        $symfonyEnv = $container->getParameter('kernel.environment');
        if ($symfonyEnv === 'dev') {
            $loader->load('services_dev.xml');
        } elseif ($symfonyEnv === 'test') {
            $loader->load('services_test.xml');
        }
    }
}

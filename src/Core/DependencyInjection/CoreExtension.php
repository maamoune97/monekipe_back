<?php

namespace App\Core\DependencyInjection;

use Exception;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class CoreExtension extends Extension
{

    /**
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        // Si besoin, instancier une classe de Configuration pour valider les options.
        // $configuration = new Configuration();
        // $config = $this->processConfiguration($configuration, $configs);d

        $loader = new YamlFileLoader($container, new FileLocator(dirname(__DIR__) . '/Resources/config'));
        $loader->load('services.yaml');
    }
}
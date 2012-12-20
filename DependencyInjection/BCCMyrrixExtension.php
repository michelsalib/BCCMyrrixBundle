<?php

namespace BCC\MyrrixBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

class BCCMyrrixExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $config);

        $container->setParameter('bcc_myrrix.host', $config['host']);
        $container->setParameter('bcc_myrrix.port', $config['port']);
        $container->setParameter('bcc_myrrix.username', $config['username']);
        $container->setParameter('bcc_myrrix.password', $config['password']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }
}

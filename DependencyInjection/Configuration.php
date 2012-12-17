<?php

namespace BCC\MyrrixBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bcc_myrrix', 'array');

        $rootNode
            ->children()
                ->scalarNode('host')
                    ->defaultValue('localhost')
                    ->example('example.com')
                    ->info('The hostname that runs the myrrix server.')
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('port')
                    ->defaultValue(8080)
                    ->example(1234)
                    ->info('The port that runs the myrrix server.')
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}

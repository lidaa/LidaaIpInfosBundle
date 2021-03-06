<?php

namespace Lidaa\IpInfosBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lidaa_ip_infos');

        $rootNode
                ->children()
                ->scalarNode('type')
                ->isRequired()
                ->end()
                ->scalarNode('ip')
                ->defaultNull()
                ->end()
                ->scalarNode('license_key')
                ->defaultNull()
                ->end()
                ->end();

        return $treeBuilder;
    }

}

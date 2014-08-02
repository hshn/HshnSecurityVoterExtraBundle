<?php

namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\Voter;

use Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\SecurityVoterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class PropertyPathVoterFactory implements SecurityVoterFactoryInterface
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'property_path';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('object_side')->end()
                ->scalarNode('token_side')->end()
            ->end()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        if (!class_exists('Symfony\Component\PropertyAccess\PropertyAccess')) {
            throw new \RuntimeException('Unable to use owner voter unless install symfony/property-access component.');
        }

        $definition = new Definition('Hshn\SecurityVoterExtraBundle\Security\Voter\PropertyPathVoter', [
            $config['classes'],
            $config['attributes'],
            $config['property_path']['token_side'],
            $config['property_path']['object_side'],
        ]);

        $container->setDefinition($id, $definition);
    }
}

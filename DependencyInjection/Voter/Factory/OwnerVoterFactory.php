<?php

namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Voter\Factory;

use Hshn\SecurityVoterExtraBundle\DependencyInjection\Voter\SecurityVoterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class OwnerVoterFactory implements SecurityVoterFactoryInterface
{
    /**
     * @return string
     */
    public function getType()
    {
        return 'owner';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('object_path')->end()
                ->scalarNode('token_path')->end()
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

        $definition = new Definition('Hshn\SecurityVoterExtraBundle\Security\Voter\OwnerVoter', [
            $config['classes'],
            $config['attributes'],
            $config['owner']['token_path'],
            $config['owner']['object_path'],
        ]);

        $container->setDefinition($id, $definition);
    }
}

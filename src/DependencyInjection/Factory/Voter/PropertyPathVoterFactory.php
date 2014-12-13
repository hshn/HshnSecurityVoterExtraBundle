<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\Voter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class PropertyPathVoterFactory extends AbstractVoterFactory
{
    /**
     * {@inheritdoc}
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
            ->beforeNormalization()
                ->ifString()
                ->then(function ($v) {
                    return ['object' => $v];
                })
            ->end()
            ->children()
                ->scalarNode('object')->end()
                ->scalarNode('token')->defaultValue('user')->end()
            ->end()
        ;
    }

    /**
     * @return string
     */
    public function getVoterClass()
    {
        if (!class_exists('Symfony\Component\PropertyAccess\PropertyAccess')) {
            throw new \RuntimeException('Unable to use owner voter unless install symfony/property-access component.');
        }

        return 'Hshn\SecurityVoterGeneratorBundle\Security\Voter\PropertyPathVoter';
    }

    /**
     * @param array $config
     *
     * @return array
     */
    public function getArguments(array $config)
    {
        return [
            $config['token'],
            $config['object'],
        ];
    }
}

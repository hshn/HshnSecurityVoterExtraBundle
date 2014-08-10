<?php

namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\Voter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class PropertyPathVoterFactory extends AbstractVoterFactory
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
     * @return string
     */
    public function getVoterClass()
    {
        if (!class_exists('Symfony\Component\PropertyAccess\PropertyAccess')) {
            throw new \RuntimeException('Unable to use owner voter unless install symfony/property-access component.');
        }

        return 'Hshn\SecurityVoterExtraBundle\Security\Voter\PropertyPathVoter';
    }

    /**
     * @param array $config
     *
     * @return array
     */
    public function getArguments(array $config)
    {
        return [
            $config['token_side'],
            $config['object_side'],
        ];
    }
}

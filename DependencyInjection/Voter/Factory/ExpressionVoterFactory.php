<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Voter\Factory;

use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Voter\SecurityVoterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ExpressionVoterFactory implements SecurityVoterFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'expression';
    }

    /**
     * {@inheritdoc}
     */
    public function addConfiguration(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->scalarNode('expression')->end()
            ->end()
        ;
    }
}

<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\Voter;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ExpressionVoterFactory extends AbstractVoterFactory
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
            ->beforeNormalization()
                ->ifString()
                ->then(function ($v) {
                    return ['expression' => $v];
                })
            ->end()
            ->children()
                ->scalarNode('expression')->end()
            ->end()
        ;
    }

    /**
     * @return string
     */
    public function getVoterClass()
    {
        if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
            throw new \RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
        }

        return 'Hshn\SecurityVoterGeneratorBundle\Security\Voter\ExpressionVoter';
    }

    /**
     * @return array
     */
    public function getArguments(array $config)
    {
        return [
            new Reference('security.expression_language'),
            $config['expression'],
        ];
    }
}

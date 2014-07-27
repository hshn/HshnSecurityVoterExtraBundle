<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Voter\Factory;

use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Voter\SecurityVoterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

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
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, array $config)
    {
        if (!class_exists('Symfony\Component\ExpressionLanguage\ExpressionLanguage')) {
            throw new \RuntimeException('Unable to use expressions as the Symfony ExpressionLanguage component is not installed.');
        }

        $definition = new Definition('Hshn\SecurityVoterGeneratorBundle\Security\Voter\ExpressionVoter', [
            $config['classes'],
            $config['attributes'],
            $this->getVoteRef($config['then']),
            $this->getVoteRef($config['else']),
            $this->getVoteRef($config['default']),
            new Reference('security.expression_language'),
            $config['expression']['expression'],
        ]);

        $container->setDefinition($id, $definition);
    }

    /**
     * @param string $name
     *
     * @return Reference
     */
    private function getVoteRef($name)
    {
        return new Reference(sprintf('hshn_security_voter_extra.vote.%s', $name));
    }
}

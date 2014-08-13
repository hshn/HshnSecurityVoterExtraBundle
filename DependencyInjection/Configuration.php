<?php

namespace Hshn\SecurityVoterExtraBundle\DependencyInjection;

use Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\SecurityVoterFactoryInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var SecurityVoterFactoryInterface[]
     */
    private $securityVoterFactories;

    /**
     * @param SecurityVoterFactoryInterface[] $securityVoterFactories
     */
    public function __construct(array $securityVoterFactories = [])
    {
        $this->securityVoterFactories = $securityVoterFactories;
    }

    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $node = $builder->root('hshn_security_voter_generator');

        /* @var $voterBuilder ArrayNodeDefinition */
        $voterBuilder = $node
            ->children()
                ->arrayNode('voters')
                ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->beforeNormalization()
                            ->ifTrue(function ($v) {
                                return !isset($v['type']);
                            })
                            ->then(function ($v) {

                                foreach ($this->securityVoterFactories as $voterFactory) {
                                    if (isset($v[$type = $voterFactory->getType()])) {
                                        $v['type'] =  $type;
                                    }
                                }

                                return $v;
                            })
                        ->end()
                        ->children()
                            ->scalarNode('type')->isRequired()->end()
                            ->arrayNode('attributes')
                                ->prototype('scalar')->end()
                            ->end()
                            ->arrayNode('classes')
                                ->children()
                                    ->scalarNode('matcher')->end()
                                ->end()
                            ->end();

        foreach ($this->securityVoterFactories as $voterFactory) {
            $voterBuilder->append($this->buildVoterNode($voterFactory));
        }

        return $builder;
    }

    /**
     * @param SecurityVoterFactoryInterface $voterFactory
     *
     * @return NodeDefinition|ArrayNodeDefinition
     */
    private function buildVoterNode(SecurityVoterFactoryInterface $voterFactory)
    {
        $builder = new TreeBuilder();
        $root = $builder->root($voterFactory->getType());
        $voterFactory->addConfiguration($root);

        return $root;
    }
}

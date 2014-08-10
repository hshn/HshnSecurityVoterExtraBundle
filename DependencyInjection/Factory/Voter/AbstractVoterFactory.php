<?php


namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\Voter;

use Hshn\SecurityVoterExtraBundle\DependencyInjection\Definition\AbstractVoterDefinition;
use Hshn\SecurityVoterExtraBundle\DependencyInjection\Definition\ProviderMatcherDefinition;
use Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\SecurityVoterFactoryInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;


/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
abstract class AbstractVoterFactory implements SecurityVoterFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(ContainerBuilder $container, $id, $name, array $config)
    {
        $container->setDefinition($matcher = "hshn_security_voter_extra.class_matcher.{$name}", new ProviderMatcherDefinition($config['classes']['matcher']));

        $voter = new AbstractVoterDefinition(new Reference($matcher), $config['attributes']);
        $voter->setClass($this->getVoterClass());

        foreach ($this->getArguments($config[$this->getType()]) as $argument) {
            $voter->addArgument($argument);
        }

        $container->setDefinition($id, $voter);
    }

    /**
     * @return string
     */
    public abstract function getVoterClass();

    /**
     * @param array $config
     *
     * @return array
     */
    public abstract function getArguments(array $config);
}

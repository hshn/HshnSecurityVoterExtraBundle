<?php


namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\Voter;

use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Definition\AbstractVoterDefinition;
use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Definition\ProviderMatcherDefinition;
use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\SecurityVoterFactoryInterface;
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
        $this->setMatcherDefinition($container, $matcher = "hshn_security_voter_generator.class_matcher.{$name}", $config['class_matcher']);

        $voter = new AbstractVoterDefinition(new Reference($matcher), $config['attributes']);
        $voter->setClass($this->getVoterClass());

        foreach ($this->getArguments($config[$this->getType()]) as $argument) {
            $voter->addArgument($argument);
        }

        $container->setDefinition($id, $voter);
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $name
     * @param string           $matcher
     *
     * @return void
     */
    private function setMatcherDefinition(ContainerBuilder $container, $name, $matcher)
    {
        if ($matcher) {
            $container->setDefinition($name, new ProviderMatcherDefinition($matcher));
        } else {
            $container->setAlias($name, 'hshn_class_matcher.class_matcher.anything.def');
        }
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

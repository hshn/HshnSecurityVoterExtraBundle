<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection;

use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\SecurityVoterFactoryInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class HshnSecurityVoterGeneratorExtension extends Extension
{
    /**
     * @var SecurityVoterFactoryInterface[]
     */
    private $securityVoterFactories;

    /**
     *
     */
    public function __construct()
    {
        $this->securityVoterFactories = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->securityVoterFactories);
    }

    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $loader->load('class_matcher.yml');

        if (isset($config['voters'])) {
            $this->loadVoter($container, $loader, $config['voters']);
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param LoaderInterface  $loader
     * @param array            $config
     *
     * @return void
     */
    private function loadVoter(ContainerBuilder $container, LoaderInterface $loader, array $config)
    {
        $public = $container->getParameter('kernel.debug');

        $loader->load('voter.yml');

        foreach ($config as $name => $voter) {
            $factory = $this->getSecurityVoterFactory($voter['type']);
            $factory->create($container, $id = "hshn_security_voter_generator.voter.$name", $name, $voter);

            $definition = $container->getDefinition($id);
            $definition->setPublic($public);
            $definition->addTag('security.voter');
        }
    }

    /**
     * @param  SecurityVoterFactoryInterface $factory
     * @return void
     */
    public function addSecurityVoterFactory(SecurityVoterFactoryInterface $factory)
    {
        $this->securityVoterFactories[$factory->getType()] = $factory;
    }

    /**
     * @param string $type
     *
     * @return SecurityVoterFactoryInterface|null
     */
    private function getSecurityVoterFactory($type)
    {
        if (isset($this->securityVoterFactories[$type])) {
            return $this->securityVoterFactories[$type];
        }
    }
}

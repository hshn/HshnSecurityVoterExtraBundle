<?php

namespace Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Voter;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
interface SecurityVoterFactoryInterface
{
    /**
     * @return string
     */
    public function getType();

    /**
     * @param ArrayNodeDefinition $builder
     *
     * @return void
     */
    public function addConfiguration(ArrayNodeDefinition $builder);

    /**
     * @param ContainerBuilder $container
     * @param string           $id
     * @param array            $config
     *
     * @return void
     */
    public function create(ContainerBuilder $container, $id, array $config);
}

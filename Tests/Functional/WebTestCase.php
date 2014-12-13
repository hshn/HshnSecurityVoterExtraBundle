<?php


namespace Hshn\SecurityVoterGeneratorBundle\Functional;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase as BaseWebTestCase;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class WebTestCase extends BaseWebTestCase
{
    /**
     * {@inheritdoc}
     */
    protected static function getKernelClass()
    {
        return 'Hshn\SecurityVoterGeneratorBundle\Functional\AppKernel';
    }

    /**
     * @var Client
     */
    private $client;

    /**
     * @param array $options
     * @param array $server
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function getClient(array $options = [], array $server = [])
    {
        return $this->client ?: $this->client = static::createClient($options, $server);
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getClient()->getContainer();
    }

    /**
     * @param $id
     *
     * @return object
     */
    protected function get($id)
    {
        return $this->getContainer()->get($id);
    }
}

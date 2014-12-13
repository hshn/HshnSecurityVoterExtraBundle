<?php


namespace Hshn\SecurityVoterGeneratorBundle\ClassMatcher;

use Hshn\ClassMatcher\MatcherInterface;
use Hshn\ClassMatcherBundle\ClassMatcher\ClassMatcherProvider;


/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ProviderMatcher implements MatcherInterface
{
    /**
     * @var \Hshn\ClassMatcherBundle\ClassMatcher\ClassMatcherProvider
     */
    private $provider;

    /**
     * @var string
     */
    private $name;

    /**
     * @param ClassMatcherProvider $provider
     * @param string               $name
     */
    public function __construct(ClassMatcherProvider $provider, $name)
    {
        $this->provider = $provider;
        $this->name = $name;
    }

    /**
     * {@inheritdoc}
     */
    public function matches($class)
    {
        return $this->provider->get($this->name)->matches($class);
    }
}

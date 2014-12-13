<?php

namespace Hshn\SecurityVoterGeneratorBundle\Security\Voter;

use Hshn\ClassMatcher\MatcherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
abstract class AbstractVoter implements VoterInterface
{
    /**
     * @var \Hshn\ClassMatcher\MatcherInterface
     */
    private $classMatcher;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param MatcherInterface $classMatcher
     * @param array            $attributes
     */
    public function __construct(MatcherInterface $classMatcher, array $attributes)
    {
        $this->classMatcher = $classMatcher;
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return empty($this->attributes) || in_array($attribute, $this->attributes, true);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $this->classMatcher->matches($class);
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$this->supportsClass(get_class($object))) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        $result = VoterInterface::ACCESS_ABSTAIN;

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

            $result = VoterInterface::ACCESS_DENIED;

            if ($this->shouldBeGranted($token, $object, $attribute)) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return $result;
    }

    /**
     * @param TokenInterface $token
     * @param object         $object
     * @param string         $attribute
     *
     * @return boolean
     */
    abstract public function shouldBeGranted(TokenInterface $token, $object, $attribute);
}

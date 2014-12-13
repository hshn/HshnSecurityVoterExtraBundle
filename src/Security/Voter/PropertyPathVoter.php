<?php

namespace Hshn\SecurityVoterGeneratorBundle\Security\Voter;

use Hshn\ClassMatcher\MatcherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class PropertyPathVoter extends AbstractVoter
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var string
     */
    private $tokenSidePath;

    /**
     * @var string
     */
    private $objectSidePath;

    /**
     * @param MatcherInterface $matcher
     * @param array            $attributes
     * @param string           $tokenSidePath
     * @param string           $objectSidePath
     */
    public function __construct(MatcherInterface $matcher, array $attributes, $tokenSidePath, $objectSidePath)
    {
        parent::__construct($matcher, $attributes);

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->tokenSidePath = $tokenSidePath;
        $this->objectSidePath = $objectSidePath;
    }

    /**
     * {@inheritdoc}
     */
    public function shouldBeGranted(TokenInterface $token, $object, $attribute)
    {
        return $this->propertyAccessor->getValue($token, $this->tokenSidePath) === $this->propertyAccessor->getValue($object, $this->objectSidePath);
    }
}

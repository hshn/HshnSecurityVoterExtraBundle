<?php

namespace Hshn\SecurityVoterExtraBundle\Security\Voter;

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
     * @param array  $classes
     * @param array  $attributes
     * @param string $tokenSidePath
     * @param string $objectSidePath
     */
    public function __construct(array $classes, array $attributes, $tokenSidePath, $objectSidePath)
    {
        parent::__construct($classes, $attributes);

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

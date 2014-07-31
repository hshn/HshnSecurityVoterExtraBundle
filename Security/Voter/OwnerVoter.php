<?php

namespace Hshn\SecurityVoterExtraBundle\Security\Voter;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class OwnerVoter extends AbstractVoter
{
    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessorInterface
     */
    private $propertyAccessor;

    /**
     * @var string
     */
    private $tokenPath;

    /**
     * @var string
     */
    private $objectPath;

    /**
     * @param array  $classes
     * @param array  $attributes
     * @param string $tokenPath
     * @param string $objectPath
     */
    public function __construct(array $classes, array $attributes, $tokenPath, $objectPath)
    {
        parent::__construct($classes, $attributes);

        $this->propertyAccessor = PropertyAccess::createPropertyAccessor();
        $this->tokenPath = $tokenPath;
        $this->objectPath = $objectPath;
    }

    /**
     * {@inheritdoc}
     */
    public function shouldBeGranted(TokenInterface $token, $object, $attribute)
    {
        return $this->propertyAccessor->getValue($token, $this->tokenPath) === $this->propertyAccessor->getValue($object, $this->objectPath);
    }
}

<?php


namespace Hshn\SecurityVoterExtraBundle\Security\Voter;


use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

abstract class AbstractVoter implements VoterInterface
{
    /**
     * @var array
     */
    private $classes;

    /**
     * @var array
     */
    private $attributes;

    /**
     * @param array $classes
     * @param array $attributes
     */
    public function __construct(array $classes, array $attributes)
    {
        $this->classes = $classes;
        $this->attributes = $attributes;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return in_array($attribute, $this->attributes, true);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return in_array($class, $this->classes, true);
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
    abstract function shouldBeGranted(TokenInterface $token, $object, $attribute);
}

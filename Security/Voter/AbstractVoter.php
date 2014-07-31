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
     * @var Vote
     */
    private $then;

    /**
     * @var Vote
     */
    private $else;

    /**
     * @var Vote
     */
    private $default;

    /**
     * @param array $classes
     * @param array $attributes
     * @param Vote  $then
     * @param Vote  $else
     * @param Vote  $default
     */
    public function __construct(array $classes, array $attributes, Vote $then, Vote $else, Vote $default)
    {
        $this->classes = $classes;
        $this->attributes = $attributes;
        $this->then = $then;
        $this->else = $else;
        $this->default = $default;
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

        foreach ($attributes as $attribute) {
            if (!$this->supportsAttribute($attribute)) {
                continue;
            }

                if ($this->then->willVote()) {
                    return $this->then->getVoteValue();
                }
            } else {
                if ($this->else->willVote()) {
                    return $this->else->getVoteValue();
                }
            if ($this->shouldBeGranted($token, $object, $attribute)) {
            }
        }

        return $this->default->getVoteValue();
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

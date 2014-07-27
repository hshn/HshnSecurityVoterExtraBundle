<?php

namespace Hshn\SecurityVoterGeneratorBundle\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class Vote
{
    const VOTE_GRANTED = 'granted';
    const VOTE_ABSTAIN = 'abstain';
    const VOTE_DENIED  = 'denied';
    const VOTE_NONE    = 'none';

    /**
     * @var bool
     */
    private $willVote;

    /**
     * @var int|null
     */
    private $voteValue;

    /**
     * @param bool     $willVote
     * @param int|null $voteValue
     */
    public function __construct($willVote, $voteValue = null)
    {
        $this->willVote = (bool) $willVote;
        $this->voteValue = $voteValue;
    }

    /**
     * @return bool
     */
    public function willVote()
    {
        return $this->willVote;
    }

    /**
     * @return int
     */
    public function getVoteValue()
    {
        return $this->voteValue;
    }

    /**
     * @param string $voteTo
     *
     * @return Vote
     * @throws \InvalidArgumentException
     */
    public static function getInstance($voteTo)
    {
        switch ($voteTo) {
            case self::VOTE_GRANTED: return new self(true, VoterInterface::ACCESS_GRANTED);
            case self::VOTE_ABSTAIN: return new self(true, VoterInterface::ACCESS_ABSTAIN);
            case self::VOTE_DENIED:  return new self(true, VoterInterface::ACCESS_DENIED);
            case self::VOTE_NONE:    return new self(false);
        }

        throw new \InvalidArgumentException();
    }
}

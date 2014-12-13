<?php


namespace Hshn\SecurityVoterGeneratorBundle\Functional\Fixtures\Entity;

use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class Post
{
    /**
     * @var \Symfony\Component\Security\Core\User\UserInterface
     */
    private $user;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}

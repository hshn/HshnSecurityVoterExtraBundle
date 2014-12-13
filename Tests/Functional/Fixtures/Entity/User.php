<?php


namespace Hshn\SecurityVoterGeneratorBundle\Functional\Fixtures\Entity;

use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class User implements UserInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getPassword()
    {
        return 'password';
    }

    /**
     * {@inheritdoc}
     */
    public function getSalt()
    {
        return 'salt';
    }

    /**
     * {@inheritdoc}
     */
    public function getUsername()
    {
        return 'username';
    }

    /**
     * {@inheritdoc}
     */
    public function eraseCredentials()
    {
        $this->password = null;
    }
}

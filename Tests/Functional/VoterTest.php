<?php


namespace Hshn\SecurityVoterExtraBundle\Tests\Functional;

use Hshn\SecurityVoterExtraBundle\Tests\Functional\Fixtures\Entity\Post;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class VoterTest extends Webtestcase
{
    /**
     * @test
     * @dataProvider providesVoterTests
     */
    public function testVoter1($expected, TokenInterface $token, $object, array $attributes)
    {
        $this->assertInstanceOf('Hshn\SecurityVoterExtraBundle\Security\Voter\ExpressionVoter', $voter = $this->getVoter('voter_1'));

        $this->assertEquals($expected, $voter->vote($token, $object, $attributes));
    }

    /**
     * @test
     * @dataProvider providesVoterTests
     */
    public function testVoter2($expected, TokenInterface $token, $object, array $attributes)
    {
        $this->assertInstanceOf('Hshn\SecurityVoterExtraBundle\Security\Voter\PropertyPathVoter', $voter = $this->getVoter('voter_2'));

        $this->assertEquals($expected, $voter->vote($token, $object, $attributes));
    }

    /**
     * @return array
     */
    public function providesVoterTests()
    {
        $user1 = $this->getUser();
        $user2 = $this->getUser();
        $anonymous = 'anony.';

        return [
            [VoterInterface::ACCESS_ABSTAIN, $this->getToken($user1), new Post($user1), []],
            [VoterInterface::ACCESS_ABSTAIN, $this->getToken($user1), new Post($user1), ['FOO', 'BAR']],

            [VoterInterface::ACCESS_GRANTED, $this->getToken($user1), new Post($user1), ['OWNER']],
            [VoterInterface::ACCESS_DENIED,  $this->getToken($user1), new Post($user2), ['OWNER']],

            [VoterInterface::ACCESS_DENIED,  $this->getToken($anonymous), new Post($user1), ['OWNER']],
        ];
    }

    /**
     * @param $user
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getToken($user)
    {
        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');

        $token
            ->expects($this->atLeastOnce())
            ->method('getUser')
            ->will($this->returnValue($user));

        return $token;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getUser()
    {
        return $this->getMock('Symfony\Component\Security\Core\User\UserInterface');
    }

    /**
     * @param $name
     *
     * @return VoterInterface
     */
    private function getVoter($name)
    {
        return $this->get("hshn_security_voter_extra.voter.{$name}");
    }
}

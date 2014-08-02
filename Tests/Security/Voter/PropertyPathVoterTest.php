<?php

namespace Hshn\SecurityVoterExtraBundle\Tests\Security\Voter;

use Hshn\SecurityVoterExtraBundle\Security\Voter\PropertyPathVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class PropertyPathVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function testShouldBeGranted($expected, $tokenPath, $objectPath, TokenInterface $token, $object)
    {
        $voter = new PropertyPathVoter([], [], $tokenPath, $objectPath);

        $this->assertEquals($expected, $voter->shouldBeGranted($token, $object, []));
    }

    /**
     * @return array
     */
    public function provideTestData()
    {
        $user = new \stdClass();
        $obj = new \stdClass();
        $obj->foo = new \stdClass();
        $obj->bar = $user;

        return [
            [false, 'user', 'foo', $this->createToken($user), $obj],
            [true, 'user', 'bar', $this->createToken($user), $obj],
        ];
    }

    /**
     * @param $user
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function createToken($user)
    {
        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token
            ->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        return $token;
    }
}

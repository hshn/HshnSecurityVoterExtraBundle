<?php


namespace Hshn\SecurityVoterGeneratorBundle\Security\Voter;

use Hshn\ClassMatcher\MatcherInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class AbstractVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getVoteTests
     */
    public function testVote($expectedResult, MatcherInterface $matcher, array $attributesSupported, array $attributes, $shouldBeGranted = null)
    {
        $voter = $this->getVoter($matcher, $attributesSupported);

        if ($shouldBeGranted !== null) {
            $voter->expects($this->once())->method('shouldBeGranted')->will($this->returnValue($shouldBeGranted));
        } else {
            $voter->expects($this->never())->method('shouldBeGranted');
        }

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');

        $this->assertSame($expectedResult, $voter->vote($token, new \stdClass(), $attributes));
    }

    /***
     * @return array
     */
    public function getVoteTests()
    {
        return [
            [VoterInterface::ACCESS_ABSTAIN, $this->getMatcher(false), [], []],
            [VoterInterface::ACCESS_DENIED,  $this->getMatcher(true),  [], ['Foo'], false],
            [VoterInterface::ACCESS_GRANTED, $this->getMatcher(true),  [], ['Foo'], true],
            [VoterInterface::ACCESS_DENIED,  $this->getMatcher(true),  [], ['Foo'], false],
            [VoterInterface::ACCESS_ABSTAIN, $this->getMatcher(true),  ['Bar'], ['Foo']],
            [VoterInterface::ACCESS_DENIED,  $this->getMatcher(true),  ['Foo'], ['Foo'], false],
            [VoterInterface::ACCESS_GRANTED, $this->getMatcher(true),  ['Foo'], ['Foo'], true],
        ];
    }

    /**
     * @param bool $result
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getMatcher($result)
    {
        $matcher = $this->getMock('Hshn\ClassMatcher\MatcherInterface');

        $matcher->expects($this->once())->method('matches')->will($this->returnValue($result));

        return $matcher;
    }

    /**
     * @param MatcherInterface $matcher
     * @param array            $attributes
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|VoterInterface
     */
    private function getVoter(MatcherInterface $matcher, array $attributes)
    {
        $voter = $this->getMockForAbstractClass('Hshn\SecurityVoterGeneratorBundle\Security\Voter\AbstractVoter', [$matcher, $attributes]);

        return $voter;
    }
}

<?php

namespace Hshn\SecurityVoterGeneratorBundle\Security\Voter;

use Hshn\SecurityVoterGeneratorBundle\Security\Voter\ExpressionVoter;

class ExpressionVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider getShouldBeGrantedTests
     */
    public function testShouldBeGranted($expected, $expressionResult)
    {
        $matcher = $this->getMock('Hshn\ClassMatcher\MatcherInterface');
        $expressionLanguage = $this->getMockBuilder('Symfony\Component\ExpressionLanguage\ExpressionLanguage')->disableOriginalConstructor()->getMock();

        $voter = new ExpressionVoter($matcher, [], $expressionLanguage, $expression = 'dummy expression');

        $token = $this->getMock('Symfony\Component\Security\Core\Authentication\Token\TokenInterface');
        $token
            ->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user = $this->getMock('Symfony\Component\Security\Core\User\UserInterface')));

        $object = new \stdClass();
        $attribute = 'Foo';

        $expressionLanguage
            ->expects($this->once())
            ->method('evaluate')
            ->with($expression, $this->callback(function (array $values) use ($token, $user, $object, $attribute) {

                $this->assertSame($token, $values['token']);
                $this->assertSame($user, $values['user']);
                $this->assertSame($object, $values['object']);
                $this->assertEquals($attribute, $values['attribute']);

                return true;
            }))
            ->will($this->returnValue($expressionResult));

        $this->assertSame($expected, $voter->shouldBeGranted($token, $object, $attribute));
    }

    /**
     * @return array
     */
    public function getShouldBeGrantedTests()
    {
        return [
            [true, true],
            [false, false],
        ];
    }
}

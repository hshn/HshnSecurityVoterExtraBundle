<?php

namespace Hshn\SecurityVoterExtraBundle\Tests\Security\Voter;

use Hshn\SecurityVoterExtraBundle\Security\Voter\ExpressionVoter;

class ExpressionVoterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testShouldBeGranted()
    {
        $expressionLanguage = $this->getMockBuilder('Symfony\Component\ExpressionLanguage\ExpressionLanguage')->disableOriginalConstructor()->getMock();
        $voter = new ExpressionVoter([], [], $expressionLanguage, $expression = 'dummy expression');

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
            ->will($this->returnValue(true));

        $this->assertTrue($voter->shouldBeGranted($token, $object, $attribute));
    }
}

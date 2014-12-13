<?php

namespace Hshn\SecurityVoterGeneratorBundle\ClassMatcher;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ProviderMatcherTest extends \PHPUnit_Framework_TestCase
{
    public function test()
    {
        $matcher = new ProviderMatcher(
            $provider = $this->getMockBuilder('Hshn\ClassMatcherBundle\ClassMatcher\ClassMatcherProvider')->disableOriginalConstructor()->getMock(),
            $name = 'Foo'
        );

        $provider
            ->expects($this->once())
            ->method('get')
            ->with('Foo')
            ->will($this->returnValue($delegate = $this->getMock('Hshn\ClassMatcher\MatcherInterface')));

        $delegate
            ->expects($this->once())
            ->method('matches')
            ->with('Bar')
            ->will($this->returnValue(true));

        $this->assertTrue($matcher->matches('Bar'));
    }
}

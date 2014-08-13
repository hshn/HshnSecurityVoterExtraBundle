<?php


namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;


/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class AbstractVoterDefinition extends DefinitionDecorator
{
    /**
     * @param Reference $matcher
     * @param array     $attributes
     * @param string    $parent
     */
    public function __construct(Reference $matcher, array $attributes, $parent = 'hshn_security_voter_extra.voter.abstract.def')
    {
        parent::__construct($parent);

        $this->replaceArgument(0, $matcher);
        $this->replaceArgument(1, $attributes);
    }
}

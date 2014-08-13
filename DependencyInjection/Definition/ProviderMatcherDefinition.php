<?php


namespace Hshn\SecurityVoterExtraBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * @author Shota Hoshino <lga0503@gmail.com>
 */
class ProviderMatcherDefinition extends DefinitionDecorator
{
    /**
     * @param string $name
     * @param string $parent
     */
    public function __construct($name, $parent = 'hshn_security_voter_extra.class_matcher.provider_matcher.def')
    {
        parent::__construct($parent);

        $this->addArgument($name);
    }
}

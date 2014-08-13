<?php

namespace Hshn\SecurityVoterExtraBundle;

use Hshn\SecurityVoterExtraBundle\DependencyInjection\HshnSecurityVoterExtraExtension;
use Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\Voter\ExpressionVoterFactory;
use Hshn\SecurityVoterExtraBundle\DependencyInjection\Factory\Voter\PropertyPathVoterFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HshnSecurityVoterExtraBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /* @var $extension HshnSecurityVoterExtraExtension */
        $extension = $container->getExtension('hshn_security_voter_extra');
        $extension->addSecurityVoterFactory(new ExpressionVoterFactory());
        $extension->addSecurityVoterFactory(new PropertyPathVoterFactory());
    }
}

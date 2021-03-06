<?php

namespace Hshn\SecurityVoterGeneratorBundle;

use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\HshnSecurityVoterGeneratorExtension;
use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\Voter\ExpressionVoterFactory;
use Hshn\SecurityVoterGeneratorBundle\DependencyInjection\Factory\Voter\PropertyPathVoterFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HshnSecurityVoterGeneratorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        /* @var $extension HshnSecurityVoterGeneratorExtension */
        $extension = $container->getExtension('hshn_security_voter_generator');
        $extension->addSecurityVoterFactory(new ExpressionVoterFactory());
        $extension->addSecurityVoterFactory(new PropertyPathVoterFactory());
    }
}

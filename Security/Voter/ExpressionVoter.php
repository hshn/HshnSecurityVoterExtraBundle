<?php

namespace Hshn\SecurityVoterExtraBundle\Security\Voter;

use Hshn\ClassMatcher\MatcherInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ExpressionVoter extends AbstractVoter
{
    /**
     * @var \Symfony\Component\ExpressionLanguage\ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * @var string
     */
    private $expression;

    /**
     * @param MatcherInterface   $matcher
     * @param array              $attributes
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expression
     */
    public function __construct(MatcherInterface $matcher, array $attributes, ExpressionLanguage $expressionLanguage, $expression)
    {
        parent::__construct($matcher, $attributes);

        $this->expressionLanguage = $expressionLanguage;
        $this->expression = $expression;
    }

    /**
     * {@inheritdoc}
     */
    public function shouldBeGranted(TokenInterface $token, $object, $attribute)
    {
        $isGranted = $this->expressionLanguage->evaluate($this->expression, [
            'token'     => $token,
            'user'      => $token->getUser(),
            'object'    => $object,
            'attribute' => $attribute,
        ]);

        return $isGranted;
    }
}

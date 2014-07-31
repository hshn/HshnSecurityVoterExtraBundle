<?php

namespace Hshn\SecurityVoterExtraBundle\Security\Voter;

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
     * @param array              $classes
     * @param array              $attributes
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expression
     */
    public function __construct(array $classes, array $attributes, ExpressionLanguage $expressionLanguage, $expression)
    {
        parent::__construct($classes, $attributes);

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

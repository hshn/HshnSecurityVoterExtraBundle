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
     * @param Vote               $then
     * @param Vote               $else
     * @param Vote               $default
     * @param ExpressionLanguage $expressionLanguage
     * @param string             $expression
     */
    public function __construct(array $classes, array $attributes, Vote $then, Vote $else, Vote $default, ExpressionLanguage $expressionLanguage, $expression)
    {
        parent::__construct($classes, $attributes, $then, $else, $default);

        $this->expressionLanguage = $expressionLanguage;
        $this->expression = $expression;
    }

    /**
     * {@inheritdoc}
     */
    public function isGranted(TokenInterface $token, $object, $attribute)
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

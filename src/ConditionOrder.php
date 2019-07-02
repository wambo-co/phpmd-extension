<?php
namespace Wambo\CodeStyle;

use PDepend\Source\AST\ASTLiteral;
use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Rule\FunctionAware;
use PHPMD\Rule\MethodAware;

class ConditionOrder extends AbstractRule implements FunctionAware, MethodAware
{
    /**
     * @param \PHPMD\AbstractNode $node
     * @return void
     */
    public function apply(AbstractNode $node)
    {
        foreach ($node->findChildrenOfType('IfStatement') as $condition) {
            foreach ($condition->findChildrenOfType('Expression') as $expression) {
                try {
                    $firstChild = $expression->getChild(0);
                    if ($firstChild->getNode() instanceof ASTLiteral) {
                        $this->addViolation($condition, array($node->getType(), $node->getName()));
                    }
                } catch (\OutOfBoundsException $e) {
                }
            }
        }
    }
}
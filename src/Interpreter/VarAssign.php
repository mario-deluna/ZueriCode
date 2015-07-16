<?php namespace ZueriCode\Interpreter;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

use ZueriCode\Node\Value as ValueNode;
use ZueriCode\Node\Variable as VariableNode;

class VarAssign extends \ZueriCode\Interpreter
{
    /**
     * Run all the code!
     */
    public function run()
    {
        $key = $this->node->getVariable()->getName();
        $value = $this->node->getValue();

        if ($this->node->getValue() instanceof ValueNode)
        {
            $this->runtime->memoryStore($key, $value->getValue());
        }
        elseif($this->node->getValue() instanceof ValueNode)
        {
            $this->runtime->memoryStore($key, $this->runtime->memoryGet($value->getName()));
        }
    }
}

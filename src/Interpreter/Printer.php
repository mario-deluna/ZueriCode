<?php namespace ZueriCode\Interpreter;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

use ZueriCode\Node\Value as ValueNode;
use ZueriCode\Node\Variable as VariableNode;

class Printer extends \ZueriCode\Interpreter
{
    /**
     * Run all the code!
     */
    public function run()
    {
        if ($this->node->getValue() instanceof ValueNode)
        {
            $value = $this->node->getValue()->getValue();
        }
        elseif($this->node->getValue() instanceof VariableNode)
        {
            $value = $this->runtime->memoryGet($this->node->getValue()->getName());
        }

        print $value . "\n";
    }
}

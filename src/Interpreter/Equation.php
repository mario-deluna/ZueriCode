<?php namespace ZueriCode\Interpreter;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

use ZueriCode\Node\Value as ValueNode;
use ZueriCode\Node\Variable as VariableNode;

class Equation extends \ZueriCode\Interpreter
{
    /**
     * Run all the code!
     */
    public function run()
    {
    	$valueA = null;

    	if ($this->node->getNodeA() instanceof ValueNode)
        {
            $valueA = $this->node->getNodeA()->getValue();
        }
        elseif($this->node->getNodeA() instanceof VariableNode)
        {
            $valueA = $this->runtime->memoryGet($this->node->getNodeA()->getName());
        }

        $valueB = null;

        if ($this->node->getNodeB() instanceof ValueNode)
        {
            $valueB = $this->node->getNodeB()->getValue();
        }
        elseif($this->node->getNodeB() instanceof VariableNode)
        {
            $valueB = $this->runtime->memoryGet($this->node->getNodeB()->getName());
        }

        // execute
        if ($this->node->getOperator() === 'smallerThan')
        {
            return $valueA < $valueB;
        }
        elseif ($this->node->getOperator() === 'greaterThan')
        {
            return $valueA > $valueB;
        }
        elseif ($this->node->getOperator() === 'equals')
        {
            return $valueA == $valueB;
        }
    }
}

<?php namespace ZueriCode\Interpreter;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

use ZueriCode\Node\Value as ValueNode;
use ZueriCode\Node\Variable as VariableNode;

class IfLogic extends \ZueriCode\Interpreter
{
    /**
     * Run all the code!
     */
    public function run()
    {
        if ($this->runChild('Equation', $this->node->getEquation()))
        {
            $this->runChild('Scope', $this->node->getPositiveScope());
        } else {

            if ($this->node->getNegativeScope()) {
                $this->runChild('Scope', $this->node->getNegativeScope());
            }
        }
    }
}

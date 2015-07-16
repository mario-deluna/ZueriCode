<?php namespace ZueriCode\Interpreter;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

class Scope extends \ZueriCode\Interpreter
{
    /**
     * Run all the code!
     */
    public function run()
    {
        foreach($this->node->getChildren() as $child)
        {
        	$class = get_class($child);
        	$class = substr($class, strrpos($class, '\\')+1);

        	$this->runChild($class, $child);
        }
    }
}

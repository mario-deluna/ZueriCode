<?php namespace ZueriCode\Node;

/**
 * ZueriCode node context interface
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node;

interface ContextInterface
{
    /**
     * Update the context (parent)
     * 
     * @param Node              $context
     * @return void
     */
    public function setContext(Node $context);
}

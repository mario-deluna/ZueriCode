<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node;

class Scope extends Node implements ContextInterface
{
    /**
     * The scopes parent scope
     *
     * @var Node
     */
    public $parent = null;

    /**
     * The scopes children nodes
     *
     * @var array[Node]
     */
    public $children = array();

    /**
     * Update the context (parent)
     * 
     * @param Node              $context
     * @return void
     */
    public function setContext(Node $context)
    {
        $this->parent = $context;
        $this->fireEvent('recivesContext', $context);
    }

    /** 
     * Registers an event on recive context
     * 
     * @param callable              $callback
     * @return void
     */
    public function onReciveContext($callback)
    {
        $this->mindEvent('recivesContext', $callback);
    }

    /**
     * Add a new child node to the scope
     *
     * @param Node             $node
     * @return void
     */
    public function addChild(Node $node, $context = null)
    {
        if (method_exists($node, 'setContext'))
        {
            if (is_null($context))
            {
                $context = $this;
            }
            
            $node->setContext($context);
        }

        $this->children[] = $node;
    }

    /** 
     * Updates the childrens parent context
     * 
     * @param Node              $context
     * @return void
     */
    public function setChildContext(Node $context)
    {
        foreach($this->children as &$child)
        {
            if (method_exists($child, 'setContext'))
            {                
                $child->setContext($context);
            }
        }
    }
}

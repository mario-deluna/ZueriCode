<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 ** 
 * @package 		ZueriCode
 * @copyright 		2015 Mario Döring
 */

use ZueriCode\Node;

class Variable extends Node
{
	/**
	 * The variable name
	 *
	 * @var Node
	 */
	protected $name = null;

    /**
     * the variable might select a subitem
     *
     * @var Node
     */
    protected $accessor = null;

	/**
     * Create a new variable node with given name
     * 
     * @param string			$name
     */
    public function __construct($name)
    {
    	$this->name = $this->setName($name);
    }
}
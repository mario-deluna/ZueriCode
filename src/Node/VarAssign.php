<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 ** 
 * @package 		ZueriCode
 * @copyright 		2015 Mario Döring
 */

use ZueriCode\Node;

class VarAssign extends Node
{
	/**
	 * The variable to be declared
	 *
	 * @var string
	 */
	protected $variable;

	/**
	 * The assigned value or expression
	 *
	 * @var string
	 */
	protected $value;
}
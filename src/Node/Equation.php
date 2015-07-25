<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 ** 
 * @package 		ZueriCode
 * @copyright 		2015 Mario Döring
 */

use ZueriCode\Node;

class Equation extends Node
{
	/**
	 * A
	 */
	protected $nodeA;

	/**
	 * B
	 */
	protected $nodeB;

	/**
	 * operator
	 * 
	 * @var string
	 */
	protected $operator;
}
<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 ** 
 * @package 		ZueriCode
 * @copyright 		2015 Mario Döring
 */

use ZueriCode\Node;
use ZueriCode\Node\Scope;

class IfLogic extends Node
{
	/**
	 * In what case
	 *
	 * @var Scope
	 */
	protected $equation;

	/**
	 * The scope if positive
	 *
	 * @var Scope
	 */
	protected $positiveScope;

	/**
	 * The scope if negative
	 *
	 * @var string
	 */
	protected $negativeScope;
}
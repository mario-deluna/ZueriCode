<?php namespace ZueriCode\Node;

/**
 * ZueriCode Parser
 ** 
 * @package 		ZueriCode
 * @copyright 		2015 Mario Döring
 */

use ZueriCode\Node;
use ZueriCode\Exception;

class Value extends Node
{
	/**
	 * The value type
	 *
	 * @var string
	 */
	protected $type = null;
	
	/**
	 * The value value >.>
	 *
	 * @var mixed
	 */
	protected $value = null;

	/**
	 * An array of available and valid value types
	 * 
	 * @var array[string]
	 */
	private $availableValueTypes = array(
		'string',
		'number',
		'boolTrue',
		'boolFalse'
	);

	/**
     * Create a new array key with an value
     * 
     * @param mixed 			$value
     * @param strign 			$type
     * @return void
     */
    public function __construct($value = null, $type = null)
    {
    	$this->value = $value;

    	if (!is_null($type))
    	{
    		$this->type = $this->setType($type);
    	}
    }

    /**
     * Validate if the given type is correct
     * 
     * @param string 				$type
     * @return string
     */
    protected function setType($type)
    {
    	if (!in_array($type, $this->availableValueTypes))
    	{
    		throw new Exception('Invalid value type ' . $type . ' given.');
    	}

    	return $type;
    }
}
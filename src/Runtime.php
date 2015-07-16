<?php namespace ZueriCode;

/**
 * ZueriCode runtime
 **
 * @package         	ZueriCode
 * @copyright       	2015 Mario Döring
 */

class Runtime
{
    /**
     * Current runtime memory
     *
     * @var array
     */
    protected $memory = [];

    /**
     * Store something in the memory
     * 
     * @param string                $key
     * @param string                $value
     *
     * @return void
     */
    public function memoryStore($key, $value)
    {
        $this->memory[$key] = $value;
    }

    /**
     * Get something in the memory
     * 
     * @param string                $key
     * @param string                $value
     *
     * @return void
     */
    public function memoryGet($key)
    {
        if (isset($this->memory[$key]))
        {
            return $this->memory[$key];
        }
    }
}

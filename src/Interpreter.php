<?php namespace ZueriCode;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

class Interpreter
{
    /**
     * The current code scope
     *
     * @var string
     */
    protected $scope = null;

    /**
     * The constructor
     *
     * @var string         $code
     * @return void
     */
    public function __construct(Node $scope)
    {
        $this->scope = $scope;
    }

    public function run()
    {
        var_dump($this->scope);
    }
}

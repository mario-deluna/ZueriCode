<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Equation as EquationNode;
use ZueriCode\Parser\Expression;
use ZueriCode\Parser;

class Equation extends Parser
{
    /**
     * The current print node
     *
     * @var ZueriCode\Node\Equation
     */
    protected $equation = null;

    /**
     * Prepare the print node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->equation = new EquationNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->equation;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        // now the expression should follow
        $this->equation->setNodeA($this->parseChild('Expression'));

        // check if the current token is an operator
        if (!$this->currentToken()->isOperator())
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        // get the operator
        $this->equation->setOperator($this->currentToken()->type);
        $this->skipToken();

        // get the second node
        $this->equation->setNodeB($this->parseChild('Expression'));

        return $this->equation;
    }
}

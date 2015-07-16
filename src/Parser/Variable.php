<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Variable as VarNode;
use ZueriCode\Parser;

class Variable extends Parser
{
    /**
     * The current scope node
     *
     * @var ZueriCode\Node\Scope
     */
    protected $variable = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->variable = new VarNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->variable;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        if ($token->type !== 'identifier')
        {
           throw $this->errorUnexpectedToken($token);
        }

        $this->skipToken();

        $this->variable->setName($token->getValue());

        return $this->variable;
    }
}

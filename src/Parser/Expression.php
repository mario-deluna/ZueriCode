<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Expression Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Value as ValueNode;
use ZueriCode\Parser;

class Expression extends Parser
{
    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare() {}

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        throw new Exception('Cannot build node from empty expression on line: ' . $this->currentToken()->line);
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

         // if the current token is a simple value create
        // a value node and return
        if ($token->isValue())
        {
            // when entered here there is no come back so
            // we can skip the current token safely
            $this->skipToken();

            return new ValueNode($token->getValue(), $token->type);
        }  
        // we also might have a variable
        elseif($token->type === 'identifier')
        {
            return $this->parseChild('Variable');
        }

        // when nothing matches erörrr
        else
        {
            throw $this->errorUnexpectedToken($token);
        }
    }
}

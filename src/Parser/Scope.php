<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Scope as ScopeNode;
use ZueriCode\Parser;

class Scope extends Parser
{
    /**
     * The current scope node
     *
     * @var Tattoo\Node\Scope
     */
    protected $scope = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->scope = new ScopeNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->scope;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $token = $this->currentToken();

        // we can skip linebreaks
        if ($token->type === 'linebreak')
        {
            $this->skipToken();
        }

        // identifier means we proabably have a var declaration
        elseif ($token->type === 'identifier') 
        {
            $this->scope->addChild($this->parseChild('VarAssign'));
        }

        // well you might guess it print is print
        elseif ($token->type === 'print') 
        {
            $this->scope->addChild($this->parseChild('Printer'));
        }

        // otherwise throw an exception
        else
        {
             throw $this->errorUnexpectedToken($token);
        }
    }
}

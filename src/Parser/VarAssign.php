<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Variable as VariableNode;
use ZueriCode\Node\VarAssign as VarAssignNode;
use ZueriCode\Parser\Expression;
use ZueriCode\Parser;

class VarAssign extends Parser
{
    /**
     * The current declaration node
     *
     * @var ZueriCode\Node\VarDeclaration
     */
    protected $declaration = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->declaration = new VarAssignNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->declaration;
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

        $this->declaration->setVariable($this->parseChild('Variable'));

        // we currently only accept simple assigns
        if ($this->currentToken()->type !== 'set')
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        $this->skipToken();

        // now the expression should follow
        $this->declaration->setValue($this->parseChild('Expression'));

        // we are done so return the node, this 
        // way the parent parser knows to continue
        return $this->declaration;
    }
}

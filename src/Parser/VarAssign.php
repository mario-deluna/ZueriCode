<?php namespace Tattoo\Parser;

/**
 * Tattoo Parser
 **
 * @package         Tattoo
 * @copyright         2015 Mario Döring
 */

use Tattoo\Node\Variable as VariableNode;
use Tattoo\Node\VarDeclaration as VarDeclarationNode;
use Tattoo\Parser\Expression;
use Tattoo\Parser;

class VarAssign extends Parser
{
    /**
     * The current declaration node
     *
     * @var Tattoo\Node\VarDeclaration
     */
    protected $declaration = null;

    /**
     * Prepare the scope node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->declaration = new VarDeclarationNode;
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

        if ($token->type !== 'variable')
        {
            throw $this->errorUnexpectedToken($token);
        }

        $this->declaration->setVariable($this->parseVariable());

        // we currently only accept simple assigns
        if ($this->currentToken()->type !== 'equal')
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

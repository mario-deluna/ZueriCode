<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\IfLogic as IfLogicNode;
use ZueriCode\Parser\Expression;
use ZueriCode\Parser;

class IfLogic extends Parser
{
    /**
     * The current print node
     *
     * @var ZueriCode\Node\IfLogic
     */
    protected $node = null;

    /**
     * Prepare the print node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->node = new IfLogicNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->node;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $this->skipToken();

        $this->node->setEquation($this->parseChild('Equation'));

        if ($this->currentToken()->type !== 'scopeOpen')
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        // parse the positive scope
        $parser = new Scope($this->getTokensUntilClosingScope(false, 'else'));  
        $this->node->setPositiveScope($parser->parse());

        // parse the negative scope
        if ($this->currentToken()->type === 'else')
        {
            $this->skipToken();

            $parser = new Scope($this->getTokensUntilClosingScope());  
            $this->node->setNegativeScope($parser->parse());
        }

        $this->skipToken();

        return $this->node;
    }
}

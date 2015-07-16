<?php namespace ZueriCode\Parser;

/**
 * ZueriCode Parser
 **
 * @package         ZueriCode
 * @copyright         2015 Mario Döring
 */

use ZueriCode\Node\Printer as PrintNode;
use ZueriCode\Parser\Expression;
use ZueriCode\Parser;

class Printer extends Parser
{
    /**
     * The current print node
     *
     * @var ZueriCode\Node\Print
     */
    protected $print = null;

    /**
     * Prepare the print node
     *
     * @return void
     */
    protected function prepare()
    {
        $this->print = new PrintNode;
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    protected function node()
    {
        return $this->print;
    }

    /**
     * Parse the next token
     *
     * @return void
     */
    protected function next()
    {
        $this->skipToken();

        // now the expression should follow
        $this->print->setValue($this->parseChild('Expression'));

        // we are done so return the node, this 
        // way the parent parser knows to continue
        return $this->print;
    }
}

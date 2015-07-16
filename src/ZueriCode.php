<?php namespace ZueriCode;

/**
 * ZueriCode main interface
 **
 * @package         	ZueriCode
 * @copyright       	2015 Mario Döring
 */

use ZueriCode\Parser\Scope as ScopeParser;

class ZueriCode
{
    /**
     * Parse tattoo code
     *
     * @throws Tattoo\Exception
     *
     * @param string            $code
     * @return array
     */
    public static function parse($code)
    {
        $lexer = new Lexer($code);
        $parser = new ScopeParser($lexer->tokens());

        return $parser->parse();
    }

    /**
     * Compile tattoo code to php
     *
     * @throws Tattoo\Exception
     *
     * @param string            $code
     * @return array
     */
    public static function run($code)
    {
        $interpreter = new Interpreter(static::parse($code));
        return $interpreter->run();
    }
}

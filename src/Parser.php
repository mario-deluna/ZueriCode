<?php namespace ZueriCode;

/**
 * ZueriCode parser
 **
 * @package             ZueriCode
 * @copyright           2015 Mario Döring
 */

abstract class Parser
{
    /**
     * The tokens in this code segment
     *
     * @var array[Token]
     */
    protected $tokens = array();

    /**
     * The current index while parsing trough the tokens
     *
     * @var int
     */
    protected $index = 0;

    /**
     * The number of tokens to parse
     *
     * @var int
     */
    protected $tokenCount = 0;

    /**
     * The constructor
     * You have to initialize the Parser with an array of lexed tokens.
     *
     * @var array[Token]             $tokens
     * @return void
     */
    public function __construct(array $tokens)
    {
        foreach ($tokens as $key => $token) 
        {
            // remove all comments and whitespaces
            if ($token->type === 'comment' || $token->type === 'whitespace') 
            {
                unset($tokens[$key]);
            }

        }

        // reset the keys
        $this->tokens = array_values($tokens);

        // count the real number of tokens
        $this->tokenCount = count($this->tokens);

        // prepare the parser
        $this->prepare();
    }

    /**
     * Prepare the parser
     *
     * @return void
     */
    abstract protected function prepare();

    /**
     * Returns all curent tokens 
     * 
     * @return array[Tattoo\Token]
     */
    public function getTokens()
    {
        return $this->tokens;
    }

    /**
     * Returns the current index
     * 
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * Retrives the current token based on the index
     *
     * @return Tattoo\Token
     */
    protected function currentToken()
    {
        if (!isset($this->tokens[$this->index]))
        {
            return null;
        }

        return $this->tokens[$this->index];
    }

    /**
     * Get the next token based on the current index
     * If the token does not exist because its off index "false" is returend.
     *
     * @param int             $i
     * @return Tattoo\Token|false
     */
    protected function nextToken($i = 1)
    {
        if (!isset($this->tokens[$this->index + $i])) 
        {
            return false;
        }

        return $this->tokens[$this->index + $i];
    }

    /**
     * Skip the next parser token by updating the index.
     *
     * @param int            $times
     * @return void
     */
    protected function skipToken($times = 1)
    {
        $this->index += $times;
    }

    /**
     * Check if all tokens have been parsed trough
     *
     * @return bool
     */
    public function parserIsDone()
    {
        return $this->index >= $this->tokenCount;
    }

    /**
     * Return all remaining tokens 
     * 
     * @param string                    $skip
     * @return array[Tattoo\Token]
     */
    protected function getRemainingTokens($skip = false)
    {
        $tokens = array();

        while (!$this->parserIsDone()) 
        {
            $tokens[] = $this->currentToken(); $this->skipToken();
        }

        if (!$skip)
        {
            $this->index -= count($tokens);
        }

        return $tokens;
    }

    /**
     * Get all tokens until the next token with given type
     *
     * @param string                     $type
     * @return array[Tattoo\Token]
     */
    protected function getTokensUntil($type)
    {
        $tokens = array();

        if (!is_array($type))
        {
            $type = array($type);
        }

        while (!$this->parserIsDone() && !in_array($this->currentToken()->type, $type)) 
        {
            $tokens[] = $this->currentToken();
            $this->skipToken();
        }

        return $tokens;
    }

    /**
     * Get all tokens until the next linebreak
     *
     * @return array[Tattoo\Token]
     */
    protected function getTokensUntilLinebreak()
    {
        return $this->getTokensUntil('linebreak');
    }

    /**
     * Skips all tokens of given type
     * 
     * @param string            $type
     * @return void
     */
    protected function skipTokensOfType($type)
    {
        while($this->currentToken() && $this->currentToken()->type === $type)
        {
            $this->skipToken();
        }
    }

    /**
     * Check if the current token is the end of a expression
     *
     * @return bool
     */
    protected function isEndOfExpression()
    {
        return $this->parserIsDone() || $this->currentToken()->type === 'linebreak';
    }

    /**
     * Check if the current parser contains a token of given type
     *
     * @param string                 $type
     * @return bool
     */
    protected function containsTokenOfType($type)
    {
        $found = false;

        foreach ($this->tokens as $token) 
        {
            if (!$found && $token->type === $type) 
            {
                $found = true;
            }
        }

        return $found;
    }

    /**
     * Retruns all tokens until the curren scope is closed again
     * 
     * @return array[Tattoo\Token]
     */
    protected function getTokensUntilClosingScope($includeScope = false)
    {
        if ($this->currentToken()->type !== 'scopeOpen')
        {
            throw $this->errorUnexpectedToken($this->currentToken());
        }

        $tokens = array();

        // include the opening scope
        if ($includeScope)
        {
            $tokens[] = $this->currentToken();
        }
        
        $this->skipToken();

       
        $currentLevel = 0;

        while($this->currentToken() && !($this->currentToken()->type === 'scopeClose' && $currentLevel === 0))
        {
            if ($this->currentToken()->type === 'scopeOpen')
            {
                $currentLevel++;
            }

            if ($this->currentToken()->type === 'scopeClose')
            {
                $currentLevel--;
            }

            $tokens[] = $this->currentToken();
            $this->skipToken();
        }

        // include the closing scope
        if ($includeScope)
        {
            $tokens[] = $this->currentToken();
        }

        return $tokens;
    }

    /**
     * Starts a new parser with the remaining or given tokens
     * 
     * @param string                $parserClass
     * @param array                 $tokens
     * @return Tattoo\Node
     */
    protected function parseChild($parserClass, $tokens = null)
    {
        $parserClass = __NAMESPACE__ . '\\Parser\\' . $parserClass;

        if (is_null($tokens))
        {
            $tokens = $this->getRemainingTokens();
        }

        $parser = new $parserClass($tokens);
        $node = $parser->parse();

        // always update the current index based on the child
        // index progress
        $this->skipToken($parser->getIndex());

        // finally return the parsed node
        return $node;
    }

    /**
     * Create new unexpected token exception
     *
     * @param Tattoo\Token                 $token
     * @return Tattoo\Parser\Exception;
     */
    protected function errorUnexpectedToken($token)
    {
        return new Exception('unexpected "' . $token->type . '" given at line ' . $token->line);
    }

    /**
     * Start the code parser and return the result
     *
     * @return array
     */
    public function parse()
    {
        // reset the result
        $this->result = array();

        // start parsing trought the tokens
        while (!$this->parserIsDone()) 
        {
            $specialNode = $this->next();

            if ($specialNode instanceof Node) 
            {
                return $specialNode;
            }
        }

        // return the result after the loop is done
        return $this->node();
    }

    /**
     * Return the node that got parsed
     *
     * @return void
     */
    abstract protected function node();

    /**
     * Parse the next token
     *
     * @return void
     */
    abstract protected function next();
}

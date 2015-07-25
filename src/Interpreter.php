<?php namespace ZueriCode;

/**
 * ZueriCode Interpreter
 **
 * @package         ZueriCode
 * @copyright       2015 Mario Döring
 */

class Interpreter
{
    /**
     * The current code node
     *
     * @var Node
     */
    protected $node = null;

    /**
     * The current runtime environment
     *
     * @var Runtime
     */
    protected $runtime = null;

    /**
     * The constructor
     *
     * @var string         $code
     * @return void
     */
    public function __construct(Node $node, $runtime = null)
    {
        if (is_null($runtime))
        {
            $runtime = new Runtime;
        }

        $this->node = $node;
        $this->runtime = $runtime;
    }

    /**
     * Run all the code!
     */
    public function run()
    {
        $this->runChild('Scope', $this->node);
    }

    /**
     * Run a child interpreter
     *
     * @param string            $interpreterClass
     * @param Node              $node
     * 
     * @return void
     */
    protected function runChild($interpreterClass, Node $node)
    {
        $interpreterClass = __NAMESPACE__ . '\\Interpreter\\' . $interpreterClass;

        $interpreter = new $interpreterClass($node, $this->runtime);
        return $interpreter->run();
    }
}

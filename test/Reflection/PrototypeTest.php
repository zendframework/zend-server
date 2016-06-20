<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Server\Reflection;

use Zend\Server\Reflection;

/**
 * Test case for \Zend\Server\Reflection\Prototype
 *
 * @group      Zend_Server
 */
class PrototypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * \Zend\Server\Reflection\Prototype object
     * @var \Zend\Server\Reflection\Prototype
     */
    protected $r;

    /**
     * Array of ReflectionParameters
     * @var array
     */
    protected $parametersRaw;

    /**
     * Array of \Zend\Server\Reflection\Parameters
     * @var array
     */
    protected $parameters;

    /**
     * Setup environment
     */
    public function setUp()
    {
        $class = new \ReflectionClass('\Zend\Server\Reflection');
        $method = $class->getMethod('reflectClass');
        $parameters = $method->getParameters();
        $this->parametersRaw = $parameters;

        $fParameters = [];
        foreach ($parameters as $p) {
            $fParameters[] = new Reflection\ReflectionParameter($p);
        }
        $this->parameters = $fParameters;

        $this->r = new Reflection\Prototype(new Reflection\ReflectionReturnValue('void', 'No return'));
    }

    /**
     * Teardown environment
     */
    public function tearDown()
    {
        unset($this->r);
        unset($this->parameters);
        unset($this->parametersRaw);
    }

    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - return:
     * - params: Optional;
     *
     * Returns: void
     */
    public function testConstructWorks()
    {
        $this->assertInstanceOf('Zend\Server\Reflection\Prototype', $this->r);
    }

    public function testConstructionThrowsExceptionOnInvalidParam()
    {
        $this->setExpectedException(
            'Zend\Server\Reflection\Exception\InvalidArgumentException',
            'One or more params are invalid'
        );
        $r1 = new Reflection\Prototype($this->r->getReturnValue(), $this->parametersRaw);
    }

    /**
     * getReturnType() test
     *
     * Call as method call
     *
     * Returns: string
     */
    public function testGetReturnType()
    {
        $this->assertEquals('void', $this->r->getReturnType());
    }

    /**
     * getReturnValue() test
     *
     * Call as method call
     *
     * Returns: \Zend\Server\Reflection\ReflectionReturnValue
     */
    public function testGetReturnValue()
    {
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionReturnValue', $this->r->getReturnValue());
    }

    /**
     * getParameters() test
     *
     * Call as method call
     *
     * Returns: array
     */
    public function testGetParameters()
    {
        $r = new Reflection\Prototype($this->r->getReturnValue(), $this->parameters);
        $p = $r->getParameters();

        $this->assertInternalType('array', $p);
        foreach ($p as $parameter) {
            $this->assertInstanceOf('Zend\Server\Reflection\ReflectionParameter', $parameter);
        }

        $this->assertEquals($this->parameters, $p);
    }
}

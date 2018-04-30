<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Zend\Server\Reflection;
use Zend\Server\Reflection\Exception\InvalidArgumentException;
use Zend\Server\Reflection\Prototype;
use Zend\Server\Reflection\ReflectionReturnValue;
use Zend\Server\Reflection\ReflectionParameter;

/**
 * Test case for \Zend\Server\Reflection\Prototype
 *
 * @group      Zend_Server
 */
class PrototypeTest extends TestCase
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
        $class = new ReflectionClass('\Zend\Server\Reflection');
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
        $this->assertInstanceOf(Prototype::class, $this->r);
    }

    public function testConstructionThrowsExceptionOnInvalidParam()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('One or more params are invalid');
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
        $this->assertInstanceOf(ReflectionReturnValue::class, $this->r->getReturnValue());
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
            $this->assertInstanceOf(ReflectionParameter::class, $parameter);
        }

        $this->assertEquals($this->parameters, $p);
    }
}

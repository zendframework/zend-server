<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection;

use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Zend\Server\Reflection;
use Zend\Server\Reflection\ReflectionParameter;

/**
 * Test case for \Zend\Server\Reflection\ReflectionParameter
 *
 * @group      Zend_Server
 */
class ReflectionParameterTest extends TestCase
{
    protected function getParameter()
    {
        $method = new ReflectionMethod('\Zend\Server\Reflection\ReflectionParameter', 'setType');
        $parameters = $method->getParameters();
        return $parameters[0];
    }

    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - r:
     * - type: Optional; has default;
     * - description: Optional; has default;
     *
     * Returns: void
     */
    public function testConstructor()
    {
        $parameter = $this->getParameter();

        $reflection = new Reflection\ReflectionParameter($parameter);
        $this->assertInstanceOf(ReflectionParameter::class, $reflection);
    }

    /**
     * __call() test
     *
     * Call as method call
     *
     * Expects:
     * - method:
     * - args:
     *
     * Returns: mixed
     */
    public function testMethodOverloading()
    {
        $r = new Reflection\ReflectionParameter($this->getParameter());

        // just test a few call proxies...
        $this->assertInternalType('bool', $r->allowsNull());
        $this->assertInternalType('bool', $r->isOptional());
    }

    /**
     * get/setType() test
     */
    public function testGetSetType()
    {
        $r = new Reflection\ReflectionParameter($this->getParameter());
        $this->assertEquals('mixed', $r->getType());

        $r->setType('string');
        $this->assertEquals('string', $r->getType());
    }

    /**
     * get/setDescription() test
     */
    public function testGetDescription()
    {
        $r = new Reflection\ReflectionParameter($this->getParameter());
        $this->assertEquals('', $r->getDescription());

        $r->setDescription('parameter description');
        $this->assertEquals('parameter description', $r->getDescription());
    }

    /**
     * get/setPosition() test
     */
    public function testSetPosition()
    {
        $r = new Reflection\ReflectionParameter($this->getParameter());
        $this->assertEquals(null, $r->getPosition());

        $r->setPosition(3);
        $this->assertEquals(3, $r->getPosition());
    }
}

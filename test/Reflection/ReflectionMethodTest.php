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
use Zend\Server\Reflection\ReflectionMethod;
use Zend\Server\Reflection\AbstractFunction;
use Zend\Server\Reflection\Node;

class ReflectionMethodTest extends TestCase
{
    protected $classRaw;
    protected $class;
    protected $method;

    protected function setUp()
    {
        $this->classRaw = new ReflectionClass(Reflection::class);
        $this->method   = $this->classRaw->getMethod('reflectClass');
        $this->class    = new Reflection\ReflectionClass($this->classRaw);
    }

    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - class:
     * - r:
     * - namespace: Optional;
     * - argv: Optional; has default;
     *
     * Returns: void
     */
    public function testConstructor()
    {
        $r = new Reflection\ReflectionMethod($this->class, $this->method);
        $this->assertInstanceOf(ReflectionMethod::class, $r);
        $this->assertInstanceOf(AbstractFunction::class, $r);

        $r = new Reflection\ReflectionMethod($this->class, $this->method, 'namespace');
        $this->assertEquals('namespace', $r->getNamespace());
    }

    /**
     * getDeclaringClass() test
     *
     * Call as method call
     *
     * Returns: \Zend\Server\Reflection\ReflectionClass
     */
    public function testGetDeclaringClass()
    {
        $r = new Reflection\ReflectionMethod($this->class, $this->method);

        $class = $r->getDeclaringClass();

        $this->assertInstanceOf(\Zend\Server\Reflection\ReflectionClass::class, $class);
        $this->assertEquals($this->class, $class);
    }

    /**
     * __wakeup() test
     *
     * Call as method call
     *
     * Returns: void
     */
    public function testClassWakeup()
    {
        $r = new Reflection\ReflectionMethod($this->class, $this->method);
        $s = serialize($r);
        $u = unserialize($s);

        $this->assertInstanceOf(ReflectionMethod::class, $u);
        $this->assertInstanceOf(AbstractFunction::class, $u);
        $this->assertEquals($r->getName(), $u->getName());
        $this->assertEquals($r->getDeclaringClass()->getName(), $u->getDeclaringClass()->getName());
    }

    /**
     * Test fetch method doc block from interface
     */
    public function testMethodDocBlockFromInterface()
    {
        $reflectionClass = new ReflectionClass(TestAsset\ReflectionMethodTestInstance::class);
        $reflectionMethod = $reflectionClass->getMethod('testMethod');

        $zendReflectionMethod = new Reflection\ReflectionMethod(
            new Reflection\ReflectionClass($reflectionClass),
            $reflectionMethod
        );
        list($prototype) = $zendReflectionMethod->getPrototypes();
        list($first, $second) = $prototype->getParameters();

        self::assertEquals('ReflectionMethodTest', $first->getType());
        self::assertEquals('array', $second->getType());
    }

    /**
     * Test fetch method doc block from parent class
     */
    public function testMethodDocBlockFromParent()
    {
        $reflectionClass = new ReflectionClass(TestAsset\ReflectionMethodNode::class);
        $reflectionMethod = $reflectionClass->getMethod('setParent');

        $zendReflectionMethod = new Reflection\ReflectionMethod(
            new Reflection\ReflectionClass($reflectionClass),
            $reflectionMethod
        );
        $prototypes = $zendReflectionMethod->getPrototypes();
        list($first, $second) = $prototypes[1]->getParameters();

        self::assertEquals('\\' . Node::class, $first->getType());
        self::assertEquals('bool', $second->getType());
    }
}

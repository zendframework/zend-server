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
 * Interface ReflectionMethodInterface
 */
interface ReflectionMethodInterface
{
    /**
     * Test method
     *
     * @param ReflectionMethodTest $reflectionMethodTest Reflection method
     * @param array                $anything             Some array information
     */
    public function testMethod(ReflectionMethodTest $reflectionMethodTest, array $anything);
}

/**
 * Class ReflectionMethodTestInstance
 * for testing only
 */
class ReflectionMethodTestInstance implements ReflectionMethodInterface {

    /**
     * {@inheritdoc}
     */
    public function testMethod(ReflectionMethodTest $reflectionMethodTest, array $anything)
    {
        // it doesn`t matter
    }
}

/**
 * Class ReflectionMethodNode
 * for testing only
 */
class ReflectionMethodNode extends Reflection\Node
{
    /**
     * {@inheritdoc}
     */
    public function setParent(Reflection\Node $node, $new = false)
    {
        // it doesn`t matter
    }
}

/**
 * Test case for \Zend\Server\Reflection\ReflectionMethod
 *
 * @group      Zend_Server
 */
class ReflectionMethodTest extends \PHPUnit_Framework_TestCase
{
    protected $_classRaw;
    protected $_class;
    protected $_method;

    protected function setUp()
    {
        $this->_classRaw = new \ReflectionClass('\Zend\Server\Reflection');
        $this->_method   = $this->_classRaw->getMethod('reflectClass');
        $this->_class    = new Reflection\ReflectionClass($this->_classRaw);
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
    public function test__construct()
    {
        $r = new Reflection\ReflectionMethod($this->_class, $this->_method);
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionMethod', $r);
        $this->assertInstanceOf('Zend\Server\Reflection\AbstractFunction', $r);

        $r = new Reflection\ReflectionMethod($this->_class, $this->_method, 'namespace');
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
        $r = new Reflection\ReflectionMethod($this->_class, $this->_method);

        $class = $r->getDeclaringClass();

        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionClass', $class);
        $this->assertEquals($this->_class, $class);
    }

    /**
     * __wakeup() test
     *
     * Call as method call
     *
     * Returns: void
     */
    public function test__wakeup()
    {
        $r = new Reflection\ReflectionMethod($this->_class, $this->_method);
        $s = serialize($r);
        $u = unserialize($s);

        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionMethod', $u);
        $this->assertInstanceOf('Zend\Server\Reflection\AbstractFunction', $u);
        $this->assertEquals($r->getName(), $u->getName());
        $this->assertEquals($r->getDeclaringClass()->getName(), $u->getDeclaringClass()->getName());
    }

    /**
     * Test fetch method doc block from interface
     */
    public function testMethodDocBlockFromInterface()
    {
        $reflectionClass = new \ReflectionClass('ZendTest\Server\Reflection\ReflectionMethodTestInstance');
        $reflectionMethod = $reflectionClass->getMethod('testMethod');

        $zendReflectionMethod = new Reflection\ReflectionMethod(new Reflection\ReflectionClass($reflectionClass), $reflectionMethod);
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
        $reflectionClass = new \ReflectionClass('ZendTest\Server\Reflection\ReflectionMethodNode');
        $reflectionMethod = $reflectionClass->getMethod('setParent');

        $zendReflectionMethod = new Reflection\ReflectionMethod(new Reflection\ReflectionClass($reflectionClass), $reflectionMethod);
        $prototypes = $zendReflectionMethod->getPrototypes();
        list($first, $second) = $prototypes[1]->getParameters();

        self::assertEquals('\Zend\Server\Reflection\Node', $first->getType());
        self::assertEquals('bool', $second->getType());
    }
}

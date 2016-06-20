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
 * Test case for \Zend\Server\Reflection\ClassReflection
 *
 * @group      Zend_Server
 */
class ReflectionClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - reflection:
     * - namespace: Optional;
     * - argv: Optional; has default;
     *
     * Returns: void
     */
    public function testConstructor()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionClass', $r);
        $this->assertEquals('', $r->getNamespace());

        $methods = $r->getMethods();
        $this->assertInternalType('array', $methods);
        foreach ($methods as $m) {
            $this->assertInstanceOf('Zend\Server\Reflection\ReflectionMethod', $m);
        }

        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'), 'namespace');
        $this->assertEquals('namespace', $r->getNamespace());
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));
        $this->assertInternalType('string', $r->getName());
        $this->assertEquals('Zend\Server\Reflection', $r->getName());
    }

    /**
     * test __get/set
     */
    public function testGetSet()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));
        $r->system = true;
        $this->assertTrue($r->system);
    }

    /**
     * getMethods() test
     *
     * Call as method call
     *
     * Returns: array
     */
    public function testGetMethods()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));

        $methods = $r->getMethods();
        $this->assertInternalType('array', $methods);
        foreach ($methods as $m) {
            $this->assertInstanceOf('Zend\Server\Reflection\ReflectionMethod', $m);
        }
    }

    /**
     * namespace test
     */
    public function testGetNamespace()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));
        $this->assertEquals('', $r->getNamespace());
        $r->setNamespace('namespace');
        $this->assertEquals('namespace', $r->getNamespace());
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass('\Zend\Server\Reflection'));
        $s = serialize($r);
        $u = unserialize($s);

        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionClass', $u);
        $this->assertEquals('', $u->getNamespace());
        $this->assertEquals($r->getName(), $u->getName());
        $rMethods = $r->getMethods();
        $uMethods = $r->getMethods();

        $this->assertEquals(count($rMethods), count($uMethods));
    }
}

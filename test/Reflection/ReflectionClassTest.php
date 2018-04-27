<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection;

use PHPUnit\Framework\TestCase;
use Zend\Server\Reflection;
use Zend\Server\Reflection\ReflectionClass;
use Zend\Server\Reflection\ReflectionMethod;

/**
 * Test case for \Zend\Server\Reflection\ClassReflection
 *
 * @group      Zend_Server
 */
class ReflectionClassTest extends TestCase
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));
        $this->assertInstanceOf(ReflectionClass::class, $r);
        $this->assertEquals('', $r->getNamespace());

        $methods = $r->getMethods();
        $this->assertInternalType('array', $methods);
        foreach ($methods as $m) {
            $this->assertInstanceOf(ReflectionMethod::class, $m);
        }

        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class), 'namespace');
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));
        $this->assertInternalType('string', $r->getName());
        $this->assertEquals('Zend\Server\Reflection', $r->getName());
    }

    /**
     * test __get/set
     */
    public function testGetSet()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));

        $methods = $r->getMethods();
        $this->assertInternalType('array', $methods);
        foreach ($methods as $m) {
            $this->assertInstanceOf(ReflectionMethod::class, $m);
        }
    }

    /**
     * namespace test
     */
    public function testGetNamespace()
    {
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));
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
        $r = new Reflection\ReflectionClass(new \ReflectionClass(Reflection::class));
        $s = serialize($r);
        $u = unserialize($s);

        $this->assertInstanceOf(ReflectionClass::class, $u);
        $this->assertEquals('', $u->getNamespace());
        $this->assertEquals($r->getName(), $u->getName());
        $rMethods = $r->getMethods();
        $uMethods = $r->getMethods();

        $this->assertCount(count($rMethods), $uMethods);
    }
}

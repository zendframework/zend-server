<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Server;

use Zend\Server\Reflection;

/**
 * @group      Zend_Server
 */
class ReflectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * reflectClass() test
     */
    public function testReflectClass()
    {
        $reflection = Reflection::reflectClass(TestAsset\ReflectionTestClass::class);
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionClass', $reflection);

        $reflection = Reflection::reflectClass(new TestAsset\ReflectionTestClass());
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionClass', $reflection);
    }

    public function testReflectClassThrowsExceptionOnInvalidClass()
    {
        $this->setExpectedException(
            Reflection\Exception\InvalidArgumentException::class,
            'Invalid argv argument passed to reflectClass'
        );
        $reflection = Reflection::reflectClass(TestAsset\ReflectionTestClass::class, 'string');
    }

    public function testReflectClassThrowsExceptionOnInvalidParameter()
    {
        $this->setExpectedException(
            Reflection\Exception\InvalidArgumentException::class,
            'Invalid class or object passed to attachClass'
        );
        $reflection = Reflection::reflectClass(false);
    }

    /**
     * reflectClass() test; test namespaces
     */
    public function testReflectClass2()
    {
        $reflection = Reflection::reflectClass(TestAsset\ReflectionTestClass::class, false, 'zsr');
        $this->assertEquals('zsr', $reflection->getNamespace());
    }

    /**
     * reflectFunction() test
     */
    public function testReflectFunction()
    {
        $reflection = Reflection::reflectFunction('ZendTest\Server\TestAsset\reflectionTestFunction');
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionFunction', $reflection);
    }

    public function testReflectFunctionThrowsExceptionOnInvalidFunction()
    {
        $this->setExpectedException('Zend\Server\Reflection\Exception\InvalidArgumentException', 'Invalid function');
        $reflection = Reflection::reflectFunction(TestAsset\ReflectionTestClass::class, 'string');
    }

    public function testReflectFunctionThrowsExceptionOnInvalidParam()
    {
        $this->setExpectedException('Zend\Server\Reflection\Exception\InvalidArgumentException', 'Invalid function');
        $reflection = Reflection::reflectFunction(false);
    }

    /**
     * reflectFunction() test; test namespaces
     */
    public function testReflectFunction2()
    {
        $reflection = Reflection::reflectFunction('ZendTest\Server\TestAsset\reflectionTestFunction', false, 'zsr');
        $this->assertEquals('zsr', $reflection->getNamespace());
    }
}

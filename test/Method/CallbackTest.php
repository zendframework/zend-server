<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Method;

use PHPUnit\Framework\TestCase;
use Zend\Server\Method;
use Zend\Server\Exception\InvalidArgumentException;

/**
 * Test class for \Zend\Server\Method\Callback
 *
 * @group      Zend_Server
 */
class CallbackTest extends TestCase
{
    /**
     * @var Method\Callback
     */
    private $callback;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->callback = new Method\Callback();
    }

    public function testClassShouldBeNullByDefault()
    {
        $this->assertNull($this->callback->getClass());
    }

    public function testClassShouldBeMutable()
    {
        $this->assertNull($this->callback->getClass());
        $this->callback->setClass('Foo');
        $this->assertEquals('Foo', $this->callback->getClass());
    }

    public function testMethodShouldBeNullByDefault()
    {
        $this->assertNull($this->callback->getMethod());
    }

    public function testMethodShouldBeMutable()
    {
        $this->assertNull($this->callback->getMethod());
        $this->callback->setMethod('foo');
        $this->assertEquals('foo', $this->callback->getMethod());
    }

    public function testFunctionShouldBeNullByDefault()
    {
        $this->assertNull($this->callback->getFunction());
    }

    public function testFunctionShouldBeMutable()
    {
        $this->assertNull($this->callback->getFunction());
        $this->callback->setFunction('foo');
        $this->assertEquals('foo', $this->callback->getFunction());
    }

    public function testFunctionMayBeCallable()
    {
        $callable = function () {
            return true;
        };
        $this->callback->setFunction($callable);
        $this->assertEquals($callable, $this->callback->getFunction());
    }

    public function testTypeShouldBeNullByDefault()
    {
        $this->assertNull($this->callback->getType());
    }

    public function testTypeShouldBeMutable()
    {
        $this->assertNull($this->callback->getType());
        $this->callback->setType('instance');
        $this->assertEquals('instance', $this->callback->getType());
    }

    public function testSettingTypeShouldThrowExceptionWhenInvalidTypeProvided()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid method callback type');
        $this->callback->setType('bogus');
    }

    public function testCallbackShouldSerializeToArray()
    {
        $this->callback->setClass('Foo')
                       ->setMethod('bar')
                       ->setType('instance');
        $test = $this->callback->toArray();
        $this->assertInternalType('array', $test);
        $this->assertEquals('Foo', $test['class']);
        $this->assertEquals('bar', $test['method']);
        $this->assertEquals('instance', $test['type']);
    }

    public function testConstructorShouldSetStateFromOptions()
    {
        $options = [
            'type'   => 'static',
            'class'  => 'Foo',
            'method' => 'bar',
        ];
        $callback = new Method\Callback($options);
        $test = $callback->toArray();
        $this->assertSame($options, $test);
    }

    public function testSettingFunctionShouldSetTypeAsFunction()
    {
        $this->assertNull($this->callback->getType());
        $this->callback->setFunction('foo');
        $this->assertEquals('function', $this->callback->getType());
    }
}

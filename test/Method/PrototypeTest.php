<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Method;

use PHPUnit\Framework\TestCase;
use Zend\Server\Method;
use Zend\Server\Method\Parameter;

/**
 * Test class for \Zend\Server\Method\Prototype
 *
 * @group      Zend_Server
 */
class PrototypeTest extends TestCase
{
    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->prototype = new Method\Prototype();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
    }

    public function testReturnTypeShouldBeVoidByDefault()
    {
        $this->assertEquals('void', $this->prototype->getReturnType());
    }

    public function testReturnTypeShouldBeMutable()
    {
        $this->assertEquals('void', $this->prototype->getReturnType());
        $this->prototype->setReturnType('string');
        $this->assertEquals('string', $this->prototype->getReturnType());
    }

    public function testParametersShouldBeEmptyArrayByDefault()
    {
        $params = $this->prototype->getParameters();
        $this->assertInternalType('array', $params);
        $this->assertEmpty($params);
    }

    public function testPrototypeShouldAllowAddingSingleParameters()
    {
        $this->testParametersShouldBeEmptyArrayByDefault();
        $this->prototype->addParameter('string');
        $params = $this->prototype->getParameters();
        $this->assertInternalType('array', $params);
        $this->assertCount(1, $params);
        $this->assertEquals('string', $params[0]);

        $this->prototype->addParameter('array');
        $params = $this->prototype->getParameters();
        $this->assertCount(2, $params);
        $this->assertEquals('string', $params[0]);
        $this->assertEquals('array', $params[1]);
    }

    public function testPrototypeShouldAllowAddingParameterObjects()
    {
        $parameter = new Method\Parameter([
            'type' => 'string',
            'name' => 'foo',
        ]);
        $this->prototype->addParameter($parameter);
        $this->assertSame($parameter, $this->prototype->getParameter('foo'));
    }

    public function testPrototypeShouldAllowFetchingParameterByNameOrIndex()
    {
        $parameter = new Method\Parameter([
            'type' => 'string',
            'name' => 'foo',
        ]);
        $this->prototype->addParameter($parameter);
        $test1 = $this->prototype->getParameter('foo');
        $test2 = $this->prototype->getParameter(0);
        $this->assertSame($test1, $test2);
        $this->assertSame($parameter, $test1);
        $this->assertSame($parameter, $test2);
    }

    public function testPrototypeShouldAllowRetrievingParameterObjects()
    {
        $this->prototype->addParameters(['string', 'array']);
        $parameters = $this->prototype->getParameterObjects();
        foreach ($parameters as $parameter) {
            $this->assertInstanceOf(Parameter::class, $parameter);
        }
    }

    public function testPrototypeShouldAllowAddingMultipleParameters()
    {
        $this->testParametersShouldBeEmptyArrayByDefault();
        $params = [
            'string',
            'array',
        ];
        $this->prototype->addParameters($params);
        $test = $this->prototype->getParameters();
        $this->assertSame($params, $test);
    }

    public function testSetParametersShouldOverwriteParameters()
    {
        $this->testPrototypeShouldAllowAddingMultipleParameters();
        $params = [
            'bool',
            'base64',
            'struct',
        ];
        $this->prototype->setParameters($params);
        $test = $this->prototype->getParameters();
        $this->assertSame($params, $test);
    }

    public function testPrototypeShouldSerializeToArray()
    {
        $return = 'string';
        $params = [
            'bool',
            'base64',
            'struct',
        ];
        $this->prototype->setReturnType($return)
                        ->setParameters($params);
        $test = $this->prototype->toArray();
        $this->assertEquals($return, $test['returnType']);
        $this->assertEquals($params, $test['parameters']);
    }

    public function testConstructorShouldSetObjectStateFromOptions()
    {
        $options = [
            'returnType' => 'string',
            'parameters' => [
                'bool',
                'base64',
                'struct',
            ],
        ];
        $prototype = new Method\Prototype($options);
        $test = $prototype->toArray();
        $this->assertSame($options, $test);
    }
}

<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection;

use Zend\Server\Reflection;
use Zend\Server\Reflection\ReflectionReturnValue;

/**
 * Test case for \Zend\Server\Reflection\ReflectionReturnValue
 *
 * @group      Zend_Server
 */
class ReflectionReturnValueTest extends \PHPUnit\Framework\TestCase
{
    /**
     * __construct() test
     *
     * Call as method call
     *
     * Expects:
     * - type: Optional; has default;
     * - description: Optional; has default;
     *
     * Returns: void
     */
    public function testConstructor()
    {
        $obj = new Reflection\ReflectionReturnValue();
        $this->assertInstanceOf(ReflectionReturnValue::class, $obj);
    }

    /**
     * getType() test
     *
     * Call as method call
     *
     * Returns: string
     */
    public function testGetType()
    {
        $obj = new Reflection\ReflectionReturnValue();
        $this->assertEquals('mixed', $obj->getType());

        $obj->setType('array');
        $this->assertEquals('array', $obj->getType());
    }

    /**
     * setType() test
     *
     * Call as method call
     *
     * Expects:
     * - type:
     *
     * Returns: void
     */
    public function testSetType()
    {
        $obj = new Reflection\ReflectionReturnValue();

        $obj->setType('array');
        $this->assertEquals('array', $obj->getType());
    }

    /**
     * getDescription() test
     *
     * Call as method call
     *
     * Returns: string
     */
    public function testGetDescription()
    {
        $obj = new Reflection\ReflectionReturnValue('string', 'Some description');
        $this->assertEquals('Some description', $obj->getDescription());

        $obj->setDescription('New Description');
        $this->assertEquals('New Description', $obj->getDescription());
    }

    /**
     * setDescription() test
     *
     * Call as method call
     *
     * Expects:
     * - description:
     *
     * Returns: void
     */
    public function testSetDescription()
    {
        $obj = new Reflection\ReflectionReturnValue();

        $obj->setDescription('New Description');
        $this->assertEquals('New Description', $obj->getDescription());
    }
}

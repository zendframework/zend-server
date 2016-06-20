<?php
/**
 * @link      http://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Server\Reflection\TestAsset;

use ZendTest\Server\Reflection\ReflectionMethodTest;

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

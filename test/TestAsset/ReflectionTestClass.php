<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\TestAsset;

/**
 * \ZendTest\Server\TestAsset\ReflectionTestClass -- test class reflection
 */
class ReflectionTestClass
{
    /**
     * Constructor
     *
     * This shouldn't be reflected
     *
     * @param mixed $arg
     */
    public function __construct($arg = null)
    {
    }

    /**
     * Public one
     *
     * @param string $arg1
     * @param array $arg2
     * @return string
     */
    public function one($arg1, $arg2 = null)
    {
    }

    /**
     * Protected _one
     *
     * Should not be reflected
     *
     * @param string $arg1
     * @param array $arg2
     * @return string
     */
    // @codingStandardsIgnoreStart
    protected function _one($arg1, $arg2 = null)
    {
        // @codingStandardsIgnoreEnd
    }

    /**
     * Public two
     *
     * @param string $arg1
     * @param string $arg2
     * @return bool|array
     */
    public static function two($arg1, $arg2)
    {
    }
}

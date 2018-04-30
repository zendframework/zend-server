<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\TestAsset;

/**
 * \ZendTest\Server\reflectionTestFunction
 *
 * Used to test reflectFunction generation of signatures
 *
 * @param  bool $arg1
 * @param string|array $arg2
 * @param string $arg3 Optional argument
 * @param string|struct|false $arg4 Optional argument
 * @return bool|array
 */
function reflectionTestFunction($arg1, $arg2, $arg3 = 'string', $arg4 = 'array')
{
}

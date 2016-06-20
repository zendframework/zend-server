<?php
/**
 * @link      http://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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

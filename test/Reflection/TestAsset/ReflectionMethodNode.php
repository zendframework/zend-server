<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection\TestAsset;

use Zend\Server\Reflection\Node;

class ReflectionMethodNode extends Node
{
    /**
     * {@inheritdoc}
     */
    public function setParent(Node $node, $new = false)
    {
        // it doesn`t matter
    }
}

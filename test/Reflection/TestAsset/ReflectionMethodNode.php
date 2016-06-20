<?php
/**
 * @link      http://github.com/zendframework/zend-Server for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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

<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2005-2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Server\Reflection;

use PHPUnit\Framework\TestCase;
use Zend\Server\Reflection\Node;

/**
 * Test case for \Zend\Server\Node
 *
 * @group      Zend_Server
 */
class NodeTest extends TestCase
{
    /**
     * __construct() test
     */
    public function testConstructor()
    {
        $node = new Node('string');
        $this->assertInstanceOf(Node::class, $node);
        $this->assertEquals('string', $node->getValue());
        $this->assertNull($node->getParent());
        $children = $node->getChildren();
        $this->assertEmpty($children);

        $child = new Node('array', $node);
        $this->assertInstanceOf(Node::class, $child);
        $this->assertEquals('array', $child->getValue());
        $this->assertEquals($node, $child->getParent());
        $children = $child->getChildren();
        $this->assertEmpty($children);

        $children = $node->getChildren();
        $this->assertEquals($child, $children[0]);
    }

    /**
     * setParent() test
     */
    public function testSetParent()
    {
        $parent = new Node('string');
        $child  = new Node('array');

        $child->setParent($parent);

        $this->assertEquals($parent, $child->getParent());
    }

    /**
     * createChild() test
     */
    public function testCreateChild()
    {
        $parent = new Node('string');
        $child = $parent->createChild('array');

        $this->assertInstanceOf(Node::class, $child);
        $this->assertEquals($parent, $child->getParent());
        $children = $parent->getChildren();
        $this->assertEquals($child, $children[0]);
    }

    /**
     * attachChild() test
     */
    public function testAttachChild()
    {
        $parent = new Node('string');
        $child  = new Node('array');

        $parent->attachChild($child);
        $this->assertEquals($parent, $child->getParent());
        $children = $parent->getChildren();
        $this->assertEquals($child, $children[0]);
    }

    /**
     * getChildren() test
     */
    public function testGetChildren()
    {
        $parent = new Node('string');
        $child = $parent->createChild('array');

        $children = $parent->getChildren();
        $types = [];
        foreach ($children as $c) {
            $types[] = $c->getValue();
        }
        $this->assertInternalType('array', $children);
        $this->assertCount(1, $children, var_export($types, 1));
        $this->assertEquals($child, $children[0]);
    }

    /**
     * hasChildren() test
     */
    public function testHasChildren()
    {
        $parent = new Node('string');

        $this->assertFalse($parent->hasChildren());
        $parent->createChild('array');
        $this->assertTrue($parent->hasChildren());
    }

    /**
     * getParent() test
     */
    public function testGetParent()
    {
        $parent = new Node('string');
        $child = $parent->createChild('array');

        $this->assertNull($parent->getParent());
        $this->assertEquals($parent, $child->getParent());
    }

    /**
     * getValue() test
     */
    public function testGetValue()
    {
        $parent = new Node('string');
        $this->assertEquals('string', $parent->getValue());
    }

    /**
     * setValue() test
     */
    public function testSetValue()
    {
        $parent = new Node('string');
        $this->assertEquals('string', $parent->getValue());
        $parent->setValue('array');
        $this->assertEquals('array', $parent->getValue());
    }

    /**
     * getEndPoints() test
     */
    public function testGetEndPoints()
    {
        $root = new Node('root');
        $child1 = $root->createChild('child1');
        $child2 = $root->createChild('child2');
        $child1grand1 = $child1->createChild(null);
        $child1grand2 = $child1->createChild('child1grand2');
        $child2grand1 = $child2->createChild('child2grand1');
        $child2grand2 = $child2->createChild('child2grand2');
        $child2grand2great1 = $child2grand2->createChild(null);
        $child2grand2great2 = $child2grand2->createChild('child2grand2great2');

        $endPoints = $root->getEndPoints();
        $endPointsArray = [];
        foreach ($endPoints as $endPoint) {
            $endPointsArray[] = $endPoint->getValue();
        }

        $test = [
            'child1',
            'child1grand2',
            'child2grand1',
            'child2grand2',
            'child2grand2great2'
        ];

        $this->assertEquals(
            $test,
            $endPointsArray,
            'Test was [' . var_export($test, 1) . ']; endPoints were [' . var_export($endPointsArray, 1) . ']'
        );
    }
}

<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace ZendTest\Server\Reflection;

use Zend\Server\Reflection;

/**
 * @group      Zend_Server
 */
class ReflectionFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionFunction', $r);
        $this->assertInstanceOf('Zend\Server\Reflection\AbstractFunction', $r);
        $params = $r->getParameters();

        $r = new Reflection\ReflectionFunction($function, 'namespace');
        $this->assertEquals('namespace', $r->getNamespace());

        $argv = ['string1', 'string2'];
        $r = new Reflection\ReflectionFunction($function, 'namespace', $argv);
        $this->assertInternalType('array', $r->getInvokeArguments());
        $this->assertEquals($argv, $r->getInvokeArguments());

        $prototypes = $r->getPrototypes();
        $this->assertInternalType('array', $prototypes);
        $this->assertNotEmpty($prototypes);
    }

    public function testPropertyOverloading()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);

        $r->system = true;
        $this->assertTrue($r->system);
    }


    public function testNamespace()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function, 'namespace');
        $this->assertEquals('namespace', $r->getNamespace());
        $r->setNamespace('framework');
        $this->assertEquals('framework', $r->getNamespace());
    }

    public function testDescription()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);
        $this->assertContains('function for reflection', $r->getDescription());
        $r->setDescription('Testing setting descriptions');
        $this->assertEquals('Testing setting descriptions', $r->getDescription());
    }

    public function testGetPrototypes()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);

        $prototypes = $r->getPrototypes();
        $this->assertInternalType('array', $prototypes);
        $this->assertEquals(8, count($prototypes));

        foreach ($prototypes as $p) {
            $this->assertInstanceOf('Zend\Server\Reflection\Prototype', $p);
        }
    }

    public function testGetPrototypes2()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function2');
        $r = new Reflection\ReflectionFunction($function);

        $prototypes = $r->getPrototypes();
        $this->assertInternalType('array', $prototypes);
        $this->assertNotEmpty($prototypes);
        $this->assertEquals(1, count($prototypes));

        foreach ($prototypes as $p) {
            $this->assertInstanceOf('Zend\Server\Reflection\Prototype', $p);
        }
    }


    public function testGetInvokeArguments()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);
        $args = $r->getInvokeArguments();
        $this->assertInternalType('array', $args);
        $this->assertEquals(0, count($args));

        $argv = ['string1', 'string2'];
        $r = new Reflection\ReflectionFunction($function, null, $argv);
        $args = $r->getInvokeArguments();
        $this->assertEquals($argv, $args);
    }

    public function testClassWakeup()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);
        $s = serialize($r);
        $u = unserialize($s);
        $this->assertInstanceOf('Zend\Server\Reflection\ReflectionFunction', $u);
        $this->assertEquals('', $u->getNamespace());
    }

    public function testMultipleWhitespaceBetweenDoctagsAndTypes()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function3');
        $r = new Reflection\ReflectionFunction($function);

        $prototypes = $r->getPrototypes();
        $this->assertInternalType('array', $prototypes);
        $this->assertNotEmpty($prototypes);
        $this->assertEquals(1, count($prototypes));

        $proto = $prototypes[0];
        $params = $proto->getParameters();
        $this->assertInternalType('array', $params);
        $this->assertEquals(1, count($params));
        $this->assertEquals('string', $params[0]->getType());
    }

    /**
     * @group ZF-6996
     */
    public function testParameterReflectionShouldReturnTypeAndVarnameAndDescription()
    {
        $function = new \ReflectionFunction('\ZendTest\Server\Reflection\function1');
        $r = new Reflection\ReflectionFunction($function);

        $prototypes = $r->getPrototypes();
        $prototype  = $prototypes[0];
        $params = $prototype->getParameters();
        $param  = $params[0];
        $this->assertContains('Some description', $param->getDescription(), var_export($param, 1));
    }
}

/**
 * \ZendTest\Server\Reflection\function1
 *
 * Test function for reflection unit tests
 *
 * @param string $var1 Some description
 * @param string|array $var2
 * @param array $var3
 * @return null|array
 */
function function1($var1, $var2, $var3 = null)
{
}

/**
 * \ZendTest\Server\Reflection\function2
 *
 * Test function for reflection unit tests; test what happens when no return
 * value or params specified in docblock.
 */
function function2()
{
}

/**
 * \ZendTest\Server\Reflection\function3
 *
 * @param  string $var1
 * @return void
 */
function function3($var1)
{
}

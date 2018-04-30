<?php
/**
 * @see       https://github.com/zendframework/zend-server for the canonical source repository
 * @copyright Copyright (c) 2018 Zend Technologies USA Inc. (https://www.zend.com)
 * @license   https://github.com/zendframework/zend-server/blob/master/LICENSE.md New BSD License
 */

namespace ZendTest\Cache;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Zend\Server\Cache;
use Zend\Server\Definition;
use Zend\Server\Method\Callback;
use Zend\Server\Method\Definition as MethodDefinition;
use Zend\Server\Server;

class CacheTest extends TestCase
{
    /**
     * @var string
     */
    private $cacheFile;

    public function tearDown()
    {
        if ($this->cacheFile) {
            unlink($this->cacheFile);
            $this->cacheFile = null;
        }
        $this->resetSkipMethods();
    }

    public function resetSkipMethods(array $methods = [])
    {
        $r = new ReflectionProperty(Cache::class, 'skipMethods');
        $r->setAccessible(true);
        $r->setValue(Cache::class, $methods);
    }

    public function testCacheCanAcceptAServerReturningAnArrayOfFunctions()
    {
        $functions = [
            'strpos' => 'strpos',
            'substr' => 'substr',
            'strlen' => 'strlen',
        ];
        $server = $this->prophesize(Server::class);
        $server->getFunctions()->willReturn($functions);

        $this->cacheFile = tempnam(sys_get_temp_dir(), 'zs');

        $this->assertTrue(Cache::save($this->cacheFile, $server->reveal()));

        $data = file_get_contents($this->cacheFile);
        $data = unserialize($data);
        $this->assertEquals($functions, $data);
    }

    public function testCacheCanAcceptAServerReturningADefinition()
    {
        $definition = new Definition();
        foreach (['strpos', 'substr', 'strlen'] as $function) {
            $callback = new Callback();
            $callback->setFunction($function);

            $method = new MethodDefinition();
            $method->setName($function);
            $method->setCallback($callback);

            $definition->addMethod($method);
        }

        $server = $this->prophesize(Server::class);
        $server->getFunctions()->willReturn($definition);

        $this->cacheFile = tempnam(sys_get_temp_dir(), 'zs');

        $this->assertTrue(Cache::save($this->cacheFile, $server->reveal()));

        $data = file_get_contents($this->cacheFile);
        $data = unserialize($data);
        $this->assertEquals($definition, $data);
    }

    public function testCacheSkipsMethodsWhenGivenAnArrayOfFunctions()
    {
        $this->resetSkipMethods(['substr']);

        $functions = [
            'strpos' => 'strpos',
            'substr' => 'substr',
            'strlen' => 'strlen',
        ];
        $server = $this->prophesize(Server::class);
        $server->getFunctions()->willReturn($functions);

        $this->cacheFile = tempnam(sys_get_temp_dir(), 'zs');

        $this->assertTrue(Cache::save($this->cacheFile, $server->reveal()));

        $data = file_get_contents($this->cacheFile);
        $data = unserialize($data);

        $expected = $functions;
        unset($expected['substr']);

        $this->assertEquals($expected, $data);
    }

    public function testCacheSkipsMethodsWhenGivenADefinition()
    {
        $this->resetSkipMethods(['substr']);

        $definition = new Definition();
        foreach (['strpos', 'substr', 'strlen'] as $function) {
            $callback = new Callback();
            $callback->setFunction($function);

            $method = new MethodDefinition();
            $method->setName($function);
            $method->setCallback($callback);

            $definition->addMethod($method);
        }

        $server = $this->prophesize(Server::class);
        $server->getFunctions()->willReturn($definition);

        $this->cacheFile = tempnam(sys_get_temp_dir(), 'zs');

        $this->assertTrue(Cache::save($this->cacheFile, $server->reveal()));

        $data = file_get_contents($this->cacheFile);
        $data = unserialize($data);

        $expected = ['strpos', 'strlen'];

        $actual = [];
        foreach ($data as $method) {
            $actual[] = $method->getName();
        }

        $this->assertEquals($expected, $actual);
    }
}

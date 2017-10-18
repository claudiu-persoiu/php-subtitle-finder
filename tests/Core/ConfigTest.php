<?php

namespace Tests\Core;

use PHPUnit\Framework\TestCase;
use Core\Config;

class ConfigTest extends TestCase
{
    protected $configClass;

    public function testNoConfig()
    {
        $this->expectExceptionMessage('Config not provided');

        Config::parse(false);
    }

    public function testNotFound()
    {
        $this->expectExceptionMessage('Config file not found');

        Config::parse('invalid');
    }

    public function testInvalidConfig()
    {
        $this->expectExceptionMessage('Invalid config file');

        Config::parse('./tests/files/invalid_config.ini');
    }

    protected function loadValidConfig()
    {
        return Config::parse('./tests/files/valid_config.ini');
    }

    public function testGetSomeGroup()
    {
        $config = $this->loadValidConfig();
        $this->assertInstanceOf(Config::class, $config->getSomeGroup());
        $this->assertTrue($config->getSomeGroup()->getFoo() === 'bar');
    }

}
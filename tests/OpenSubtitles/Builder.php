<?php

namespace Tests\OpenSubtitles;

use Core\Config;
use PHPUnit\Framework\TestCase;
use Provider\OpenSubtitles\Builder as OBuilder;

class Builder extends TestCase
{
    protected $builder;

    protected function setUp()
    {
        $this->builder = new OBuilder(new Config([]));
    }

    public function testFindByHashInterface()
    {
        $this->assertInstanceOf(\Core\FinderInterface::class, $this->builder->findByHash());
    }

    public function testFindByNameInterface()
    {
        $this->assertInstanceOf(\Core\FinderInterface::class, $this->builder->findByName());
    }

}
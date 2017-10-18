<?php

namespace Provider\OpenSubtitles;

use Core\Config;
use Provider\OpenSubtitles\Hash\Finder as HashFinder;
use Provider\OpenSubtitles\Title\Finder as TitleFinder;

class Builder
{
    protected $connection;

    public function __construct(Config $config)
    {
        $this->connection = new ConnectionManager($config);
    }

    public function findByHash()
    {
        return new HashFinder($this->connection);
    }

    public function findByName()
    {
        return new TitleFinder($this->connection);
    }
}
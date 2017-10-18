<?php

namespace Provider\OpenSubtitles\Hash;

use Provider\OpenSubtitles\ConnectionManager;
use Provider\OpenSubtitles\FinderAbstract;

class Finder extends FinderAbstract
{
    const METHOD = 'SearchSubtitles';

    protected $calculator;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->calculator = new Calculator();
        parent::__construct($connectionManager);
    }

    public function search(\SplFileInfo $fileInfo)
    {
        $hash = $this->calculator->calculateHash($fileInfo);

        $result = $this->connection->call('SearchSubtitles', [
            'moviehash' => $hash, 'moviebytesize' => $fileInfo->getSize()
        ]);

        return $this->processResult($result, $fileInfo);
    }
}
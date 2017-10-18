<?php

namespace Provider\OpenSubtitles\Title;

use Provider\OpenSubtitles\FinderAbstract;

class Finder extends FinderAbstract
{
    const METHOD = 'SearchSubtitles';

    public function search(\SplFileInfo $fileInfo)
    {
        $result = $this->connection->call('SearchSubtitles', [
            'query'=> $fileInfo->getBasename('.'.$fileInfo->getExtension())
        ]);

        return $this->processResult($result, $fileInfo);
    }
}
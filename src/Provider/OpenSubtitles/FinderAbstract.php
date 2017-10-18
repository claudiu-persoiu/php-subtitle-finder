<?php

namespace Provider\OpenSubtitles;

use Core\FinderInterface;

abstract class FinderAbstract implements FinderInterface
{
    protected $connection;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connection = $connectionManager;
    }

    protected function getSubtitleUrls(array $result)
    {
        if (!empty($result['data'])) {
            foreach ($result['data'] as $subtitle) {
                if (!empty($subtitle['SubDownloadLink'])) {
                    return $subtitle['SubDownloadLink'];
                }
            }
        }
    }

    protected function downloadUrl($url, \SplFileInfo $fileInfo)
    {
        if ($url) {
            $subtitleFile = $fileInfo->getPath() . '/' . $fileInfo->getBasename($fileInfo->getExtension()) . 'srt';
            $subtitleContent = gzdecode(file_get_contents($url));

            file_put_contents($subtitleFile, $subtitleContent);

            return true;
        }
    }

    protected function processResult(array $result, \SplFileInfo $fileInfo)
    {
        $url = $this->getSubtitleUrls($result);

        if ($url) {
            return $this->downloadUrl($url, $fileInfo);
        }
    }
}
#!/usr/bin/env php
<?php

require_once 'vendor/autoload.php';

$path = false;

if (isset($argv[1])) {
    $path = $argv[1];
} else {
    $torrentDir = getenv('TR_TORRENT_DIR');
    $torrentName = getenv('TR_TORRENT_NAME');
    if ($torrentName) {
        $path = $torrentDir . '/' . $torrentName;
    }
}

if (!$path) {
    throw new \Exception('Path not specified');
}

$config = \Core\Config::parse('config.ini');

$openSubtitlesManager = new \Provider\OpenSubtitles\Builder($config->getOpenSubtitles());

$obj = new \Core\Processor();
$obj->addFinder($openSubtitlesManager->findByHash());
$obj->addFinder($openSubtitlesManager->findByName());

$obj->process($path);
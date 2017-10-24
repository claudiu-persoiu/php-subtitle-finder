<?php

require_once __DIR__ . '/vendor/autoload.php';

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

try {

    if (!$path) {
        throw new \Exception('Path not specified');
    }

    $configPath = getcwd() . '/config.ini';

    $config = \Core\Config::parse($configPath);

    $openSubtitlesManager = new \Provider\OpenSubtitles\Builder($config->getOpenSubtitles());

    $obj = new \Core\Processor();
    $obj->addFinder($openSubtitlesManager->findByHash());
    $obj->addFinder($openSubtitlesManager->findByName());

    $obj->process($path);

} catch (\Exception $exception) {
    echo $exception->getMessage() . "\n";
}
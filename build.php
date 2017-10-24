<?php

$file = 'subfinder.phar';

$phar = new Phar($file, 0, $file);

$phar->startBuffering();

$phar->buildFromDirectory(dirname(__FILE__));

$stub = "#!/usr/bin/env php 
<?php Phar::mapPhar(''); 
require 'phar://' . __FILE__ . '/console.php'; 
__HALT_COMPILER(); ?>";

$phar->setStub($stub);

$phar->stopBuffering();

chmod($file, 0770);
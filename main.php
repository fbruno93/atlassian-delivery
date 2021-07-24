<?php

require 'vendor/autoload.php';

use bfy\Helper\DotEnv;
use bfy\MainController;
use bfy\Options;

// Load .env
try {
    (new DotEnv(__DIR__ . '/.env.local'))->load();
} catch (InvalidArgumentException $e) {
    (new DotEnv(__DIR__ . '/.env'))->load();
}

/********************
 * Option statement *
 ********************/
$options = new Options();

if (!$options->isValid()) {
    echo $options->help();
    exit(1);
}

if ($options->askHelp()){
    echo $options->help();
    exit(0);
}

$response = (new MainController())
    ->start($options);

echo $response->getOutput();
exit($response->getCode());
<?php

require __DIR__.'/vendor/autoload.php';

use Hangman\GameCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new GameCommand());
$application->run();

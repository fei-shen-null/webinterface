<?php
// Error Reporting Level
error_reporting(E_ALL | E_STRICT);

// Include Path for Webinterface Application and Tests
$webinterface = realpath(dirname(__DIR__));
$tests = realpath(__DIR__ . '/../tests');

$paths = array(
    $webinterface,
    $tests,
    get_include_path() // attach original include paths
);
set_include_path(implode(PATH_SEPARATOR, $paths));


// Composer Autoloader
if (is_file(__DIR__ . '/../vendor/autoload.php')) {
    include_once __DIR__ . '/../vendor/autoload.php';
} else {
    echo 'Could not find "vendor/autoload.php". Did you forget to run "composer install --dev"?' . PHP_EOL;
    exit(1);
}

<?php

declare(strict_types = 1);

require_once __DIR__ . '/../vendor/autoload.php';

$classDirs = array(__DIR__);
$autoloader = new \iRAP\Autoloader\Autoloader($classDirs);
$testFiles = \iRAP\CoreLibs\Filesystem::getDirContents(__DIR__ . '/tests', false, false, true);

foreach ($testFiles as $testFilename) {
    $testClassName = substr($testFilename, 0, -4);
    include_once __DIR__ . "/tests/{$testFilename}";
    
    /* @var $test TestInterface */
    $test = new $testClassName();
    $test->run();
    
    if ($test->getPassed()) {
        $testStatusString = "PASSED";
    }
    else {
        $testStatusString = "FAILED";
    }
    
    print "{$testFilename} : {$testStatusString}" . PHP_EOL;
}
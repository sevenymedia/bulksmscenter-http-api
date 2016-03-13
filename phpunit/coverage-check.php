<?php

if (!extension_loaded('xdebug')) {
    die('The Xdebug extension is not loaded. No code coverage will be generated.');
}
if (!file_exists($inputFile = $argv[1])) {
    throw new InvalidArgumentException('Invalid input file provided');
}
if (!($percentage = min(100,max(0,(int)$argv[2])))) {
    throw new InvalidArgumentException('An integer checked percentage must be given as second parameter');
}

$xml = new SimpleXMLElement(file_get_contents($inputFile));
$totalElements = 0;
$checkedElements = 0;

foreach ($xml->xpath('//metrics') as $metricXml) {
    $totalElements += (int)$metricXml['elements'];
    $checkedElements += (int)$metricXml['coveredelements'];
}

if (($coverage = ($checkedElements/$totalElements)*100) < $percentage) {
    echo "Code coverage is {$coverage}%, which is below the accepted {$percentage}%".PHP_EOL;
    exit(1);
}

echo "Code coverage is {$coverage}% - OK!".PHP_EOL;

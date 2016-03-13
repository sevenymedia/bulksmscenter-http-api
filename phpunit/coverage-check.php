<?php

if (!extension_loaded('xdebug')) {
    die('The Xdebug extension is not loaded. No code coverage will be generated.');
}
if (!file_exists($strInputFile = $argv[1])) {
    throw new InvalidArgumentException('Invalid input file provided');
}

if (!($fltPercentage = min(100,max(0,(int)$argv[2])))) {
    throw new InvalidArgumentException('An integer checked percentage must be given as second parameter');
}

$objXml = new SimpleXMLElement(file_get_contents($strInputFile));
$intTotalElements = 0;
$intCheckedElements = 0;

foreach ($objXml->xpath('//metrics') as $objMetricXml) {
    $intTotalElements += (int)$objMetricXml['elements'];
    $intCheckedElements += (int)$objMetricXml['coveredelements'];
}

if (($fltCoverage = ($intCheckedElements/$intTotalElements)*100) < $fltPercentage) {
    echo "Code coverage is {$fltCoverage}%, which is below the accepted {$fltPercentage}%".PHP_EOL;
    exit(1);
}

echo "Code coverage is {$fltCoverage}% - OK!".PHP_EOL;

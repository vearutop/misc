<?php
require_once 'DSRunner.php';

$stat = array();
$length = array();

$samplesCount = 1000;

if (isset($_SERVER['argv'][1])) {
    $samplesCount = $_SERVER['argv'][1];
}

$iterationsCount = round(100000 / $samplesCount);
if ($iterationsCount < 10) {
    $iterationsCount = 10;
}



//print_r($_SERVER['argv']);

// preparing sample data
/*
$data = array();
for ($i = 0;$i < $samplesCount; ++$i) {
	$data ['test_' . $i]= $i;
}
*/


$data = array();

$point = &$data;
for ($i = 0;$i < $samplesCount; ++$i) {
    $point ['test_' . $i]= $i;

    if (!$i % 50) {
        $point = &$point['deeper'];
    }
}

//$data = (object)$data;


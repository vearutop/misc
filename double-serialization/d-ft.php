<?php

$chartsPoints = array();


foreach ($stat as $test => $time) {
    if (substr($test, -strlen('_serialization')) == '_serialization') {
        $norm = $stat['single_serialization'];
    } else {
        $norm = $stat['single_unserialization'];
    }
    $l = $length[str_replace(array('_serialization', '_unserialization'), '', $test)];

    $chartsPoints [DSRunner::CHART_SPEED_BS][$test] []= array($l, $iterationsCount * $l / $time);
    $chartsPoints [DSRunner::CHART_SPEED_ES][$test] []= array($l, $iterationsCount * $samplesCount / $time);

    if ('single_' !== substr($test, 0, 7)) {
        $chartsPoints [DSRunner::CHART_SINGLE][$test] []= array($l, 100 * $time / $norm);
    }
}

/*
foreach ($length as $test => $l) {
    $charts['Length, b'][$test] [] = array($l, $samplesCount);
}
*/


echo json_encode($chartsPoints);
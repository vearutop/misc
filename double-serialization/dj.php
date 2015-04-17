<?php
require_once 'DSRunner.php';
require 'd-hd.php';

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = json_encode($data);
}
$stat['single_serialization'] = microtime(1) - $start;


$tmp = json_encode($data);
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = json_decode($tmp, 1);
}
$stat['single_unserialization'] = microtime(1) - $start;
$length['single'] = strlen($tmp);


////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = json_encode(json_encode($data));
}
$stat['double_serialization'] = microtime(1) - $start;


$tmp = json_encode(json_encode($data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = json_decode(json_decode($tmp, 1));
}
$stat['double_unserialization'] = microtime(1) - $start;
$length['double'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = json_encode(array('data' => $data));
}
$stat['nested_serialization'] = microtime(1) - $start;


$tmp = json_encode(array('data' => $data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = json_decode($tmp, 1);
	$tmp2 = $tmp2['data'];
}
$stat['nested_unserialization'] = microtime(1) - $start;
$length['nested'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = json_encode(array('data' => json_encode($data)));
}
$stat['double_nested_serialization'] = microtime(1) - $start;


$tmp = json_encode(array('data' => json_encode($data)));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = json_decode($tmp, 1);
	$tmp2 = json_decode($tmp2['data'], 1);
}
$stat['double_nested_unserialization'] = microtime(1) - $start;
$length['double_nested'] = strlen($tmp);


require 'd-ft.php';
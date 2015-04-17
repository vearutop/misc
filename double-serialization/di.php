<?php

if (!extension_loaded('igbinary')) {
    die();
}

require 'd-hd.php';

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = igbinary_serialize($data);
}
$stat['single_serialization'] = microtime(1) - $start;


$tmp = igbinary_serialize($data);
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = igbinary_unserialize($tmp);
}
$stat['single_unserialization'] = microtime(1) - $start;
$length['single'] = strlen($tmp);


////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = igbinary_serialize(igbinary_serialize($data));
}
$stat['double_serialization'] = microtime(1) - $start;


$tmp = igbinary_serialize(igbinary_serialize($data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = igbinary_unserialize(igbinary_unserialize($tmp));
}
$stat['double_unserialization'] = microtime(1) - $start;
$length['double'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = igbinary_serialize(array('data' => $data));
}
$stat['nested_serialization'] = microtime(1) - $start;


$tmp = igbinary_serialize(array('data' => $data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = igbinary_unserialize($tmp);
	$tmp2 = $tmp2['data'];
}
$stat['nested_unserialization'] = microtime(1) - $start;
$length['nested'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = igbinary_serialize(array('data' => igbinary_serialize($data)));
}
$stat['double_nested_serialization'] = microtime(1) - $start;


$tmp = igbinary_serialize(array('data' => igbinary_serialize($data)));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = igbinary_unserialize($tmp);
	$tmp2 = igbinary_unserialize($tmp2['data']);
}
$stat['double_nested_unserialization'] = microtime(1) - $start;
$length['double_nested'] = strlen($tmp);


require 'd-ft.php';
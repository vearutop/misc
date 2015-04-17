<?php
require 'd-hd.php';

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = serialize(serialize($data));
}
$stat['double_serialization'] = microtime(1) - $start;


$tmp = serialize(serialize($data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = unserialize(unserialize($tmp));
}
$stat['double_unserialization'] = microtime(1) - $start;
$length['double'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = serialize(array('data' => $data));
}
$stat['nested_serialization'] = microtime(1) - $start;


$tmp = serialize(array('data' => $data));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = unserialize($tmp);
	$tmp2 = $tmp2['data'];
}
$stat['nested_unserialization'] = microtime(1) - $start;
$length['nested'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp = serialize(array('data' => serialize($data)));
}
$stat['double_nested_serialization'] = microtime(1) - $start;


$tmp = serialize(array('data' => serialize($data)));
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
	$tmp2 = unserialize($tmp);
	$tmp2 = unserialize($tmp2['data']);
}
$stat['double_nested_unserialization'] = microtime(1) - $start;
$length['double_nested'] = strlen($tmp);

/////////////////////////////////

$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
    $tmp = serialize($data);
}
$stat['single_serialization'] = microtime(1) - $start;


$tmp = serialize($data);
$start = microtime(1);
for ($i = 0;$i < $iterationsCount;++$i) {
    $tmp2 = unserialize($tmp);
}
$stat['single_unserialization'] = microtime(1) - $start;
$length['single'] = strlen($tmp);


////////////////////////////////

require 'd-ft.php';
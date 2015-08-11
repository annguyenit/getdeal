<?php

function hexstr($hexstr) {
  $hexstr = str_replace(' ', '', $hexstr);
  $hexstr = str_replace('\x', '', $hexstr);
  $retstr = pack('H*', $hexstr);
  return $retstr;
}

function strhex($string) {
  $hexstr = unpack('H*', $string);
  return array_shift($hexstr);
}

$teststr = "64 65 74 61 69 6c 73";
#$teststr = "01 02 63 00 39 00 45 00 36 00 43 00 32 00 30 00 41 00 30 00 00 00";

ini_set('display_errors',1);
error_reporting(E_ALL);

$ascii_inputs = array("details", "abcde");
$hex_inputs = array("64 65 74 61 69 6c 73", "64657461696c73", '\x64\x65\x74\x61\x69\x6c\x73');

print "<pre>";

foreach ($ascii_inputs as $str) {
  $str2 = strhex($str);
  //printf("strhex('%s') = %s  [%s]\n", $str, var_export($str2, true), implode(" ", str_split($str2, 2)));
echo  $str2;
}

foreach ($hex_inputs as $str) {
  $str2 = hexstr($str);
  //printf("hexstr('%s') = %s\n", $str, var_export($str2, true));
}


print "</pre><hr>\n";
//show_source(__FILE__);
?>
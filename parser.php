<?php

# Backend work sample configuration parser
# https://github.com/spqt/backend-work-sample-parser

$config = 'config.txt';
if (!file_exists($config) || !is_readable($config)) {
  echo 'File not found or not readable: '.$config."\n";
  exit(1);
}

$lines = file_get_contents($config);
if ($lines === false) {
  echo 'Failed reading file contents: '.$config."\n";
  exit(1);
}

$lines = explode("\n", $lines);

$result = array();

function set_level($result, $levels, $value) {
  $value = trim($value);
  # weird invisible letters located between db and 01
  # $value = str_replace("\xad", '', $value);
  # $value = str_replace("\xc2", '', $value);
  $level = array_shift($levels);
  $result[$level] = isset($result[$level]) ? $result[$level] : array();

  # still levels left
  if (count($levels)) {
    $result[$level] = set_level($result[$level], $levels, $value);
  } else {
    if (substr($value, 0,1) === '"') {
      $value = substr($value, 1);
      if (strpos($value, '"') !== false) {
        $value = substr($value, 0, strpos($value, '"'));
      }
    } else if (substr($value, 0,1) === '\'') {
      $value = substr($value, 1);
      if (strpos($value, '\'') !== false) {
        $value = substr($value, 0, strpos($value, '\''));
      }
    } else if (strtolower($value) === 'false') {
      $value = false;
    } else if (strtolower($value) === 'true') {
      $value = true;
    } else if (is_numeric($value)) {
      if (strpos($value, '.') !== false) {
        $value = floatval($value);
      } else {
        $value = intval($value);
      }
    }
    $result[$level] = $value;
  }
  return $result;
}

foreach ($lines as $line) {
  # comment removal
  $line = preg_replace('/^\s*\#+.*$/', '',$line);
  # <space><a-z A-Z 0-9 .><space>=<space><data>
  $regex = '/\s*([a-zA-Z0-9\.]+)\s*=\s*(.*)\s*/';
  $line = preg_match_all($regex, $line, $matches);
  if (!isset($matches[1][0], $matches[2][0])) {
    continue;
  }
  $levels = explode('.', $matches[1][0]);
  $result = set_level($result, $levels, $matches[2][0]);
}

if (!isset($result['cache']['ttl']['connection']['timeout'])) {
  # add missing level required in output
  $result = set_level($result, array('cache', 'connection', 'timeout'), 3);
}

var_dump($result);

?>

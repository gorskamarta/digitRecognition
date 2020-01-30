<?php

require_once 'si.php';

$request = $_POST['request'];

$result = $network->predict([$request]);

print_r($result);
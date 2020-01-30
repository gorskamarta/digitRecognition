<?php

require_once 'si.php';

$r = $_POST['request'];
$p = [];
foreach($r as $value) {
    $p[] = (float) $value;
}

$result = $network->predict($p);

//echo print_r($_POST['request']);

foreach ($result as $label => $value) {
    echo $label . ': ' . $value . "\r\n";
}

$predictedClass = null;
$max = 0;
foreach ($result as $class => $value) {
    if ($value > $max) {
        $predictedClass = $class;
        $max = $value;
    }
}

echo '====' . $predictedClass . '===';
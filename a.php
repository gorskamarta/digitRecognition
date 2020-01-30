<?php


$input = [
    1, 1, 1, 1, 1, 2, 2, 2, 2, 2,
    1, 1, 1, 1, 1, 2, 2, 2, 2, 2,
    1, 1, 1, 1, 1, 2, 2, 2, 2, 2,
    1, 1, 1, 1, 1, 2, 2, 2, 2, 2,
    1, 1, 1, 1, 1, 2, 2, 2, 2, 2,
    3, 3, 3, 3, 3, 4, 4, 4, 4, 4,
    3, 3, 3, 3, 3, 4, 4, 4, 4, 4,
    3, 3, 3, 3, 3, 4, 4, 4, 4, 4,
    3, 3, 3, 3, 3, 4, 4, 4, 4, 4,
    3, 3, 3, 3, 3, 4, 4, 4, 4, 4,
];

$inputSize = 10;
$outputSize = 2;

$output = [];
for ($row = 0 ; $row < $outputSize; $row++) {
    for ($column = 0 ; $column < $outputSize ; $column++) {

        $val = 0;
        for ($inputRow = $row*($inputSize/$outputSize) ; $inputRow < ($row+1)*($inputSize/$outputSize) ; $inputRow++) {
            for ($inputColumn = $column*($inputSize/$outputSize) ; $inputColumn < ($column+1)*($inputSize/$outputSize); $inputColumn++) {
                $val += $input[$inputColumn+($inputRow*$inputSize)];
            }
        }
        $output[] = $val/(($inputSize/$outputSize)*($inputSize/$outputSize));

    }
}

print_r($output);
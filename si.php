<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('vendor/autoload.php');

// Create neural network
$hiddenLayer1 = new \Phpml\NeuralNetwork\Layer(196, \Phpml\NeuralNetwork\Node\Neuron::class, new \Phpml\NeuralNetwork\ActivationFunction\Sigmoid);
$network = new \Phpml\Classification\MLPClassifier(
    784,
    [
        $hiddenLayer1
    ],
    [
        0,
        1,
        2,
        3,
        4,
        5,
        6,
        7,
        8,
        9
    ],
    1
);

// Initialize weights
$weightsFile = __DIR__ . '/data/weights';
$lastBatchFile = __DIR__ . '/data/last-batch';
if (!is_file($weightsFile)) {
    touch($weightsFile);
}
if (!is_file($lastBatchFile)) {
    touch($lastBatchFile);
}

$weights = unserialize(file_get_contents($weightsFile));
if (is_array($weights)) {
    foreach ($network->getLayers() as $layerNr => $layer) {
        foreach ($layer->getNodes() as $nodeNr => $node) {
            if (!$node instanceof \Phpml\NeuralNetwork\Node\Neuron) {
                continue;
            }
            foreach ($node->getSynapses() as $synapseNr => $synapse) {
                $synapse->setWeight($weights[$layerNr][$nodeNr][$synapseNr]);
            }
        }
    }
}
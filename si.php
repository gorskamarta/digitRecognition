<?php

require('vendor/autoload.php');


echo "Creating neural network...\r\n";
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
echo "Network created!\r\n";



// Initialize weights
echo "Initializing neural network...\r\n";
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
    echo "Network initialized!\r\n";
} else {
    echo "Skipping... No initial weights filie found!\r\n";
}




// Load data "Loading training data...\r\n";
echo "Loading training data...\r\n";
$trainDataset = new Phpml\Dataset\MnistDataset(__DIR__ . '/data/train-images.idx3-ubyte', __DIR__ . '/data/train-labels.idx1-ubyte');
echo "Training data loaded!\r\n";



// Preparing data
echo "Preparing training data batches...\r\n";
$samples = $trainDataset->getSamples();
$targets = $trainDataset->getTargets();
$batchSize = 10;
$samplesBatches = array_chunk($samples, $batchSize);
$targetsBatches = array_chunk($targets, $batchSize);
echo "Training data batches prepared!/r/n";


// Training
echo "Training network...\r\n";
$lastBatch = (int) file_get_contents($lastBatchFile);
for ($i = $lastBatch ; $i < count($samplesBatches); ++$i) {
    echo "Batch " . ($i+1) . "/" . count($samplesBatches);
    $start = microtime(true);
    $network->partialTrain($samplesBatches[$i], $targetsBatches[$i]);
    echo " [" . (microtime(true) - $start) . " sec]\r\n";

    // Save all weights
    $weights = [];
    foreach ($network->getLayers() as $layerNr => $layer) {
        $nodesWeights = [];
        foreach ($layer->getNodes() as $nodeNr => $node) {
            if (!$node instanceof \Phpml\NeuralNetwork\Node\Neuron) {
                continue;
            }

            $synapsesWeights = [];
            foreach ($node->getSynapses() as $synapse) {
                $synapsesWeights[] = $synapse->getWeight();
            }
            $nodesWeights[] = $synapsesWeights;
        }
        $weights[] = $nodesWeights;
    }
    file_put_contents($weightsFile, serialize($weights));
    file_put_contents($lastBatchFile, $i);

}
echo "Network trained!\r\n";

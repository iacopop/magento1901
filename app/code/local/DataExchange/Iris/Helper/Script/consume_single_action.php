<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

require('../app/Mage.php');
Mage::app()->setCurrentStore(0);
Mage::setIsDeveloperMode(true);

$options = array("action:","id:","type:");

$arguments = getopt("",$options);

if(!isset($arguments["action"]) || !isset($arguments["id"]) || !isset($arguments["type"])){
    return;
}

$actionType = $arguments["action"];
$actionId = $arguments["id"];
$productType = $arguments["type"];

$consumer = new DataExchange_Iris_Model_Consumer_Default();
if($actionType == "insert" && $productType == "simple"){
    $consumer->consumeSimpleProductRow($actionId);
}

if($actionType == "insert" && $productType == "configurable"){
    $consumer->consumeConfigurableProductRow($actionId);
}
return;

?>

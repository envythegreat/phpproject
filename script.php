<?php
require_once("./Database.php");

$db = new Database();


$Product_Data = file_get_contents('products.json');
$productData = json_decode($Product_Data, true);
echo "<pre>";
  $db->insert("product", $productData[1]);
echo "</pre>";


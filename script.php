<?php
require_once("./Database.php");

$db = new Database();


$Product_Data = file_get_contents('products.json');
$productsData = json_decode($Product_Data, true);
foreach($productsData as $productData):
  $db->insert("products", $productData);
endforeach;



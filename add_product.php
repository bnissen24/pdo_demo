<?php

include 'pdo.php';

$categoryID = filter_input(INPUT_POST, 'categoryID');
$productCode = filter_input(INPUT_POST, 'productCode');
$productName = filter_input(INPUT_POST, 'productName');
$listPrice = filter_input(INPUT_POST, 'listPrice');

try {
    $query = 'INSERT INTO products
                (categoryID, productCode, productName, listPrice)
              VALUES
                (:categoryID, :productCode, :productName, :listPrice)';
    $statement = $db->prepare($query);
    $statement->bindValue(':categoryID', $categoryID);
    $statement->bindValue(':productCode', $productCode);
    $statement->bindValue(':productName', $productName);
    $statement->bindValue(':listPrice', $listPrice);
    $statement->execute();
    $statement->closeCursor();

    header('Location: index.php');
} catch (Exception $error) {
    $error_messasge = $error->getMessage();
    echo "Error INSERTING into SQL: $error_messasge";
}
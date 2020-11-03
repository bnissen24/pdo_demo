<?php
    include 'pdo.php';

    $categoryID = filter_input(INPUT_GET, 'categoryID');
    if (empty($categoryID)) {
        $categoryID = 1;
    }

    try {
        $query = 'SELECT * FROM products WHERE categoryID = :categoryID';
        $statement = $db->prepare($query);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->execute();
        $products = $statement->fetchAll();
        $statement->closeCursor();

        $query2 = 'SELECT * FROM categories';
        $statement2 = $db->prepare($query2);
        $statement2->execute();
        $categories = $statement2->fetchAll();
        $statement2->closeCursor();
    } catch (Exception $error) {
        $error_message = $error->getMessage();
        echo "Error running SELECT on SQL: $error_message";
    }
?>

<h2>PDO Demo</h2>

<form method="index.php" method="get">
    <select name="categoryID">
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['categoryID'] ?>"
                    <?php if ($category['categoryID'] === $categoryID) echo 'selected' ?>>
                <?php echo $category['categoryName'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Filter">
</form>

<table border="1">
    <tr>
        <th>Product Code</th>
        <th>Product Name</th>
        <th>List Price</th>
    </tr>
    <?php foreach ($products as $product) : ?>
    <tr>
        <td><?php echo $product['productCode']; ?></td>
        <td><?php echo $product['productName']; ?></td>
        <td><?php echo $product['listPrice']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<h2>Add Product</h2>
<form action="add_product.php" method="post">
    <input type="hidden" name="categoryID"
           value="<?php echo $categoryID ?>"><br>

    <label for="category_id">Product Code</label><br>
    <input type="text" name="productCode"><br>

    <label for="category_id">Product Name</label><br>
    <input type="text" name="productName"><br>

    <label for="category_id">List Price</label><br>
    <input type="text" name="listPrice"><br>

    <input type="submit" value="Add Product">
</form>

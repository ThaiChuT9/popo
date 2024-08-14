<?php
require_once("./functions/db.php");
$conn = connect();
$id = $_GET['id'];
$sql = "SELECT * FROM `products` WHERE product_id = $id";
$products = select($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("head.php") ?>
</head>

<body>
    <?php include_once("nav.php") ?>
    <div class="container">
        <?php foreach ($products as $product): ?>
            <h1><?php echo htmlspecialchars($product["name"]) ?></h1>
            <p><?php echo htmlspecialchars($product["price"]) ?></p>
            <p><?php echo htmlspecialchars($product["description"]) ?></p>
            <?php if ($product["qty"] > 0): ?>
                <p>In Stock: <?php echo htmlspecialchars($product["qty"]) ?></p>
            <?php else: ?>
                <p>Out of Stock</p>
            <?php endif; ?>
        <?php endforeach; ?>
        <div class="row">
            <div class="col-3">
                <form class="d-flex" action="/addtocart.php" method="post">
                    <input name="buy_qty" class="form-control me-2" type="number" value="1" placeholder="Quantity"
                        aria-label="">
                    <button class="btn btn-outline-warning" type="submit">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
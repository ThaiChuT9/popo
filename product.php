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
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="row">
                    <div class=" card p-3 my-3">
                        <h1><?php echo htmlspecialchars($product["name"]) ?></h1>
                        <p>$<?php echo htmlspecialchars($product["price"]) ?></p>
                        <p><?php echo htmlspecialchars($product["description"]) ?></p>
                        <?php if ($product["qty"] > 0): ?>
                            <p>In Stock: <?php echo htmlspecialchars($product["qty"]) ?></p>
                            <div class="row">
                                <div class="col-3">
                                    <form class="d-flex" action="addtocart.php" method="post">
                                        <div class="input-group">
                                            <input type="hidden" name="id" value="<?php echo $product["product_id"]; ?>" />
                                            <input name="buy_qty" class="form-control me-2" type="number" value="1" min="1" max="<?php echo $product['qty']; ?>" placeholder="Quantity" aria-label="">
                                            <button class="btn btn-outline-warning" type="submit">Add to cart</button>
                                        </div>
                                    </form>
                                </div>
                            <?php else: ?>
                                <p>Out of Stock</p>
                                <div class="col-3">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="hidden" name="id" value="<?php echo $product["product_id"]; ?>" />
                                            <input name="buy_qty" class="form-control me-2" type="number" value="0" min="0" placeholder="Quantity" aria-label="" readonly>
                                            <button class="btn btn-outline-warning" type="submit" disabled>Add to cart</button>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                            </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
                </div>
</body>

</html>
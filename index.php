<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("head.php") ?>
</head>

<body>
    <?php include_once("nav.php") ?>

    <?php
    require_once("./functions/db.php");
    $conn = connect();
    if (isset($_GET['s'])) {
      $searchQuery = $conn->real_escape_string($_GET['s']);
      $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$searchQuery%'";
    } else {
      $sql = "SELECT * FROM `products`";
    }
    $products = select($sql);

    
    ?>

    <div class="container">
        <div class="row">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $item): ?>
                    <div class="col-3 mb-3 mt-3">
                      <div class="card">
                        <img src="<?php echo $item["thumbnail"] ?>" class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo htmlspecialchars($item["name"]) ?></h5>
                          <p>$<?php echo htmlspecialchars($item["price"]) ?></p>
                          <p class="card-text"><?php echo htmlspecialchars($item["description"]) ?></p>
                          <a href="product.php?id=<?php echo $item['product_id']; ?>" class="btn btn-primary">Detail</a>
                        </div>
                      </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>

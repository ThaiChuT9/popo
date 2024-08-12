<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("head.php") ?>
</head>

<body>
    <?php include_once("nav.php") ?>

    <?php 
        $conn = new mysqli("localhost", "root", "", "yessir");
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        // Check if a search query is provided
        if (isset($_GET['s'])) {
            $searchQuery = $conn->real_escape_string($_GET['s']);
            $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$searchQuery%'";
        } else {
            $sql = "SELECT * FROM `products`";
        }

        $result = $conn->query($sql);
        $products = [];
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $products[] = $row;
          }
        }
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
                          <a href="#" class="btn btn-primary">Detail</a>
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

<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$cart = isset($_SESSION["cart"])?$_SESSION["cart"]:[];
require_once "./functions/db.php";
$categories = select("SELECT * FROM `categories`");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">NAVBAR</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <?php foreach ($categories as $category): ?>
          <li class="nav-item">
            <a style="font-size: small;" class="nav-link" href="index.php?cat_id=<?php echo $category['cat_id']; ?>"><?php echo htmlspecialchars($category['cat_name']); ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
      <form class="d-flex" action="index.php" method="get">
        <input name="s" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      <a href="cart.php" class="btn btn-outline-dark ms-1">
        <i class="bi bi-cart"></i>
        <span class="badge rounded-pill text-bg-dark"><?php echo count($cart);?></span>
      </a>
    </div>
  </div>
</nav>
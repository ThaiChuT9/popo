<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once("head.php") ?>
    <title>Cart</title>
    <?php 
        session_start();
        require_once("./functions/cart.php");
        $cartItems = getCartItems();
    ?>
</head>
<body>
    <?php include_once("nav.php") ?>
    <div class="container">
        <div class="row-8 mt-5 ">
            <h3>Shoping cart</h3>
            <hr>
            <div class="row">
                <div class="col-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cartItems)): ?>
                                <?php foreach ($cartItems as $index =>$item): ?>
                                    <tr>
                                        <td><?= $item['name'] ?></td>
                                        <td>$<?= $item['price'] ?></td>
                                        <td><?= $item['buy_qty'] ?></td>
                                        <td>$<?= $item['total'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Your cart is empty</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <p class="card-text">
                                <?php
                                    $grandtotal = array_sum(array_column($cartItems, 'total')); 
                                    echo htmlspecialchars('$'.$grandtotal);
                                ?>
                            </p>
                            <a href="check_out.php" class="btn btn-primary">Checkout</a>
                            <a href="clear_cart.php" class="btn btn-danger">Clear Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
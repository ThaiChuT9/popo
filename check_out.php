<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("./functions/cart.php");
$items = getCartItems();
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include_once("head.php"); ?>
</head>
<?php include_once("nav.php"); ?>

<body>
    <div class="container mt-5">
        <form action="place_order.php" method="post">

            <div class="row justify-content-center">
                <div class="col-6">
                    <h1>Billing Details</h1>
                    <form action="place_order.php" method="post">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">First & Last name</label>
                            <input type="text" name="customer_name" class="form-control" id="exampleFormControlInput1"
                                placeholder="Full name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Telephone</label>
                            <input type="text" name="telephone" class="form-control" id="exampleFormControlInput1"
                                placeholder="09xxxxxxx">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="exampleFormControlInput1"
                                placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Address</label>
                            <input type="text" name="shipping_address" class="form-control" id="exampleFormControlInput1" placeholder="Address">
                        </div>
                        <h1>Payment Method</h1>
                        <div class="formborder">
                            <div class="form-check box">
                                <input class="form-check-input" name="payment_method" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault1">
                                <label class="form-check-label" for="flexRadioDefault1">
                                    COD
                                </label>
                            </div>
                        </div>
                        <div class="formborder  mt-3">

                            <div class="form-check box">
                                <input class="form-check-input" value="PAYPAL" name="payment_method" type="radio" name="flexRadioDefault"
                                    id="flexRadioDefault2" checked>
                                <label class="form-check-label" for="flexRadioDefault2">
                                    PayPal
                                </label>
                            </div>
                        </div>
                        <p class="text-center mt-3"> By clicking this button you agree to the <u>terms and
                                conditions</u></p>
                        <div class="d-grid gap-2 marginbot">
                            <button type="submit" class="btn btn-success ">Place Order</button>
                        </div>
                </div>
                <div class="col-4 ">
                    <div class="row borderbbbb">
                        <h4><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor"
                                class="bi bi-cart4" viewBox="0 0 16 16">
                                <path
                                    d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                            </svg> Cart Sumary(<a href="cart.php">edit</a>)</h4>

                        <div class="col">
                            <?php foreach ($items as $item): ?>
                                <?php $grand_total += $item["buy_qty"] * $item["price"]; ?>
                                <div class="row border-bottom mt-3 mb-3">
                                    <div class="col-8 pb-3">
                                        <strong> <?php echo $item["name"]; ?>
                                            (<?php echo $item["buy_qty"]; ?>x<?php echo $item["price"]; ?>)</strong><br>
                                        <?php echo $item['details'] ?>

                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-3 text-end pt-4">
                                        <span
                                            class="mt-3"><strong><?php echo $item["buy_qty"] * $item["price"]; ?></strong></span>
                                    </div>
                                </div>
                            <?php endforeach ?>
                            <div class="col text-end">
                                <strong>Total: <?php echo htmlspecialchars('$' . $grand_total); ?></strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </div>

</body>

</html>
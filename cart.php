<?php
// =========================
// z1960727 Justin Carney  |
// z2051554 Aasim Ghani    |
// Tyler Rouw 21942888     |
// Liam Belh z2047328      |
// Trevor Jannsen z2036452 |
// =========================

session_start();
include 'includes/header.php';

// ======================
// Handle cart actions  |
// ======================

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT, ['min_range' => 0]);

    if ($product_id && $quantity !== false) {
        if (isset($_POST['update'])) {
            if ($quantity > 0) {
                $_SESSION['cart'][$product_id] = $quantity;
            } else {
                unset($_SESSION['cart'][$product_id]);
            }
        } elseif (isset($_POST['remove'])) {
            unset($_SESSION['cart'][$product_id]);
        }
    }
}

// ======================
// Display cart         |
// ======================

?>
<div class="cart-container">
    <h2>Shopping Cart</h2>
    <?php if (!empty($_SESSION['cart'])) : ?>
        <form method="post">
            <table class="cart-table">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
                <?php
                $grand_total = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity) :
                    $stmt = $pdo->prepare("SELECT * FROM Product WHERE product_id = ?");
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    if ($product) :
                        $subtotal = $product['price'] * $quantity;
                        $grand_total += $subtotal;
                ?>
                        <tr>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td>$<?= number_format($product['price'], 2) ?></td>
                            <td>
                                <input type="number" name="quantity" value="<?= $quantity ?>" min="0">
                                <input type="hidden" name="product_id" value="<?= $product_id ?>">
                            </td>
                            <td>$<?= number_format($subtotal, 2) ?></td>
                            <td>
                                <button type="submit" name="update" class="btn">Update</button>
                                <button type="submit" name="remove" class="btn">Remove</button>
                            </td>
                        </tr>
                <?php
                    endif;
                endforeach;
                ?>
                <tr class="total-row">
                    <td colspan="3">Grand Total</td>
                    <td colspan="2">$<?= number_format($grand_total, 2) ?></td>
                </tr>
            </table>
        </form>
        <div class="cart-actions">
            <a href="products.php" class="btn">Continue Shopping</a>
            <a href="checkout.php" class="btn">Checkout</a>
        </div>
    <?php else : ?>
        <p>Your cart is empty.</p>
        <a href="products.php" class="btn">Start Shopping</a>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
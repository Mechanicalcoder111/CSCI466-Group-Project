<?php
// =========================
// z1960727 Justin Carney  |
// z2051554 Aasim Ghani    |
// Tyler Rouw 21942888     |
// Liam Belh z2047328      |
// Trevor Jannsen z2036452 |
// =========================

session_start();
include 'includes/config.php';
include 'includes/header.php';

if (empty($_SESSION['cart']) || !isset($_SESSION['user_id'])) {
    header('Location: products.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();

        // -----------------
        // Calculate total |
        // -----------------
        $total = 0;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM Product WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $price = $stmt->fetchColumn();
            $total += $price * $quantity;
        }
        
        // --------------
        // Insert order |
        // --------------
        $stmt = $pdo->prepare("INSERT INTO `Order` (user_id, total_amount, shipping_address) VALUES (?, ?, ?)");
        $stmt->execute([
            $_SESSION['user_id'],
            $total,
            filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING)
        ]);
        $order_id = $pdo->lastInsertId();
        
        // ----------------------
        // Insert order details |
        // ----------------------
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $stmt = $pdo->prepare("SELECT price FROM Product WHERE product_id = ?");
            $stmt->execute([$product_id]);
            $price = $stmt->fetchColumn();

            $stmt = $pdo->prepare("INSERT INTO OrderDetail (order_id, product_id, quantity, price_at_purchase) VALUES (?, ?, ?, ?)");
            $stmt->execute([$order_id, $product_id, $quantity, $price]);
            
            // --------------
            // Update stock |
            // --------------
            $stmt = $pdo->prepare("UPDATE Product SET stock_quantity = stock_quantity - ? WHERE product_id = ?");
            $stmt->execute([$quantity, $product_id]);
        }

        $pdo->commit();
        unset($_SESSION['cart']);
        echo "<div class='success'>Order placed successfully! Order ID: $order_id</div>";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "<div class='error'>Error processing order: " . $e->getMessage() . "</div>";
    }
} else {
?>
    <div class="checkout-form">
        <h2>Checkout</h2>
        <form method="post">
            <label>Shipping Address:
                <textarea name="address" required></textarea>
            </label>
            <button type="submit" class="btn">Place Order</button>
        </form>
    </div>
<?php
}
include 'includes/footer.php';
?>
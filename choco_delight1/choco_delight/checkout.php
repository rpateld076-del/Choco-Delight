<?php
require_once 'inc/functions.php';
require_login();

$cart = $_SESSION['cart'] ?? [];
if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

$customer = get_user($_SESSION['customer_id']);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $payment_method = $_POST['payment_method'];
    $valid = true;

    // VALIDATION
    if ($payment_method === 'UPI') {
        if (empty($_POST['upi_name']) || empty($_POST['upi_id'])) {
            $msg = "Please fill all UPI details.";
            $valid = false;
        }
    } elseif ($payment_method === 'Card') {
        if (empty($_POST['card_name']) || empty($_POST['card_number']) || empty($_POST['expiry']) || empty($_POST['cvv'])) {
            $msg = "Please fill all Card details.";
            $valid = false;
        } elseif (strlen($_POST['card_number']) !== 16) {
            $msg = "Card number must be exactly 16 digits.";
            $valid = false;
        } elseif (strlen($_POST['cvv']) < 3 || strlen($_POST['cvv']) > 4) {
            $msg = "CVV must be 3 or 4 digits.";
            $valid = false;
        }
    } elseif ($payment_method === 'Net Banking') {
        if (empty($_POST['bank_name']) || empty($_POST['account_name'])) {
            $msg = "Please fill all Net Banking details.";
            $valid = false;
        }
    }

    if ($valid) {
        // calculate total
        $total = 0;
        foreach ($cart as $it) {
            $total += $it['price'] * $it['qty'];
        }

        // insert order
        $stmt = $conn->prepare(
            "INSERT INTO orders (customer_id, total, status)
             VALUES (?, ?, ?)"
        );
        $status = 'Pending';
        $stmt->bind_param('ids', $_SESSION['customer_id'], $total, $status);

        if ($stmt->execute()) {

            $order_id = $stmt->insert_id;

            // insert order items
            $stmt2 = $conn->prepare(
                "INSERT INTO order_items (order_id, product_id, qty, price)
                 VALUES (?, ?, ?, ?)"
            );

            foreach ($cart as $it) {
                $stmt2->bind_param(
                    'iiii',
                    $order_id,
                    $it['id'],
                    $it['qty'],
                    $it['price']
                );
                $stmt2->execute();
            }

            /* =======================
               INSERT PAYMENT
            ======================= */

            $payment_status = 'Pending';
            $details = '';

            if ($payment_method === 'UPI') {
                $details = "UPI Name: ".$_POST['upi_name']." | UPI ID: ".$_POST['upi_id'];
            }

            if ($payment_method === 'Card') {
                $details = "Card Holder: ".$_POST['card_name']." | Card Last4: ".substr($_POST['card_number'], -4);
            }

            if ($payment_method === 'Net Banking') {
                $details = "Bank: ".$_POST['bank_name']." | Name: ".$_POST['account_name'];
            }

            // If table has 'details' column, we could save it. But schema didn't show it.
            // Using 'method' column for method name.
            
            $pay = $conn->prepare(
                "INSERT INTO payments (order_id, amount, method, status)
                 VALUES (?, ?, ?, ?)"
            );

            $pay->bind_param(
                "idss",
                $order_id,
                $total,
                $payment_method,
                $payment_status
            );

            $pay->execute();
            $pay->close();

            unset($_SESSION['cart']);
            header("Location: invoice.php?id=".$order_id);
            exit;

        } else {
            $msg = "Order failed: " . $stmt->error;
        }
    }
}

include 'inc/header.php';
?>

<div class="checkout-container">

    <h2>Checkout</h2>

    <?php if ($msg): ?>
    <div class="alert alert-error"><?php echo $msg; ?></div>
    <?php endif; ?>

    <div class="card">
        <h3>Deliver To</h3>
        <p>
            <strong><?php echo esc($customer['name']); ?></strong><br>
            <?php echo nl2br(esc($customer['address'])); ?><br>
            <?php echo esc($customer['phone']); ?>
        </p>
    </div>

    <div class="card">
        <h3>Payment Method</h3>
        <form method="post" id="checkoutForm">

            <select name="payment_method" id="payment_method" required onchange="showFields()">
                <option value="">-- Select Payment Method --</option>
                <option value="Cash on Delivery">Cash on Delivery</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
                <option value="Net Banking">Net Banking</option>
            </select>

            <!-- UPI -->
            <div id="upi" class="pm-fields">
                <input type="text" name="upi_name" class="upi-req" placeholder="UPI Name">
                <input type="text" name="upi_id" class="upi-req" placeholder="UPI ID">
            </div>

            <!-- Card -->
            <div id="card" class="pm-fields">
                <input type="text" name="card_name" class="card-req" placeholder="Card Holder Name">
                <input type="text" name="card_number" class="card-req" placeholder="Card Number" pattern="\d{16}" title="Card number must be 16 digits" maxlength="16" minlength="16">
                <input type="text" name="expiry" class="card-req" placeholder="MM/YY">
                <input type="password" name="cvv" class="card-req" placeholder="CVV" pattern="\d{3,4}" title="CVV must be 3 or 4 digits" maxlength="4" minlength="3">
            </div>

            <!-- Net Banking -->
            <div id="netbanking" class="pm-fields">
                <input type="text" name="bank_name" class="bank-req" placeholder="Bank Name">
                <input type="text" name="account_name" class="bank-req" placeholder="Account Holder Name">
            </div>

            <button type="submit" class="button">Place Order</button>
        </form>
    </div>

</div>

<script>
function showFields() {
    let pm = document.getElementById("payment_method").value;
    let fields = document.querySelectorAll('.pm-fields');
    fields.forEach(f => f.style.display = 'none');

    // Reset required
    document.querySelectorAll('.upi-req, .card-req, .bank-req').forEach(i => i.required = false);

    if (pm === "UPI") {
        document.getElementById("upi").style.display = "block";
        document.querySelectorAll('.upi-req').forEach(i => i.required = true);
    }
    if (pm === "Card") {
        document.getElementById("card").style.display = "block";
        document.querySelectorAll('.card-req').forEach(i => i.required = true);
    }
    if (pm === "Net Banking") {
        document.getElementById("netbanking").style.display = "block";
        document.querySelectorAll('.bank-req').forEach(i => i.required = true);
    }
}
</script>

<style>
.checkout-container {
    max-width: 600px;
    margin: 40px auto;
    padding: 0 15px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 25px;
}

.card {
    background-color: #fff;
    padding: 20px 25px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

h3 {
    margin-bottom: 15px;
    color: #444;
}

p {
    line-height: 1.6;
    color: #555;
}

select, input {
    width: 100%;
    padding: 10px 12px;
    margin-bottom: 10px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
    box-sizing: border-box;
}

.button {
    background-color: #28a745;
    color: #fff;
    padding: 12px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
    transition: 0.3s;
}

.button:hover {
    background-color: #218838;
}

.pm-fields {
    display: none;
}

.alert {
    padding: 12px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

.alert-error {
    background-color: #f8d7da;
    color: #721c24;
}
</style>

<?php include 'inc/footer.php'; ?>

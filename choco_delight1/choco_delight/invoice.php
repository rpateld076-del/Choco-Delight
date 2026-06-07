<?php
require_once 'inc/functions.php';
// basic security check if user is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id'] ?? 0);

// Fetch order
$stmt = $conn->prepare('SELECT * FROM orders WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    die("Order not found");
}

// Security: Check if order belongs to logged in user
if ($order['customer_id'] != $_SESSION['customer_id']) {
    die("Access Denied");
}

// Fetch order items
$stmt = $conn->prepare('SELECT oi.*, p.name FROM order_items oi JOIN products p ON p.id = oi.product_id WHERE oi.order_id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch customer details for the invoice
$cust = get_user($order['customer_id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $order['id']; ?></title>
    <!-- html2pdf CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .company-info {
            text-align: right;
            color: #777;
        }
        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .to, .meta {
            width: 45%;
        }
        .meta {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #fafafa;
            font-weight: 600;
        }
        .total-row {
            font-weight: bold;
            font-size: 1.2em;
        }
        .buttons {
            max-width: 800px;
            margin: 20px auto;
            text-align: right;
        }
        .btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-print {
            background-color: #28a745;
            margin-right: 10px;
        }
        
        /* Hide buttons in PDF/Print */
        @media print {
            .buttons { display: none; }
            body { background: #fff; }
            .invoice-container { box-shadow: none; padding: 0; }
        }
    </style>
</head>
<body>

    <div class="buttons">
        <button class="btn btn-print" onclick="window.print()">Print</button>
        <button class="btn" onclick="generatePDF()">Download PDF</button>
        <a href="profile.php" class="btn" style="background:#6c757d;">Back to Profile</a>
    </div>

    <div class="invoice-container" id="invoice">
        <div class="header">
            <div>
                <h1>INVOICE</h1>
                <p>#<?php echo $order['id']; ?></p>
            </div>
            <div class="company-info">
                <strong>Choco Delight</strong><br>
                123 Chocolate Street<br>
                Sweet City, 560001<br>
                Email: support@chocodelight.com
            </div>
        </div>

        <div class="invoice-details">
            <div class="to">
                <h3>Bill To:</h3>
                <strong><?php echo htmlspecialchars($cust['name']); ?></strong><br>
                <?php echo nl2br(htmlspecialchars($cust['address'])); ?><br>
                Phone: <?php echo htmlspecialchars($cust['phone']); ?>
            </div>
            <div class="meta">
                <h3>Details:</h3>
                <strong>Order Date:</strong> <?php echo date("F d, Y", strtotime($order['created_at'])); ?><br>
                <strong>Status:</strong> <?php echo $order['status']; ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): 
                    $row_total = $it['price'] * $it['qty'];
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($it['name']); ?></td>
                    <td style="text-align: center;"><?php echo $it['qty']; ?></td>
                    <td style="text-align: right;">₹<?php echo number_format($it['price'], 2); ?></td>
                    <td style="text-align: right;">₹<?php echo number_format($row_total, 2); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: bold;">Grand Total</td>
                    <td style="text-align: right; font-weight: bold; font-size: 1.1em;">₹<?php echo number_format($order['total'], 2); ?></td>
                </tr>
            </tbody>
        </table>

        <div style="margin-top: 40px; text-align: center; color: #777; font-size: 0.9em;">
            <p>Thank you for your Order</p>
        </div>
    </div>

    <script>
        function generatePDF() {
            const element = document.getElementById('invoice');
            const opt = {
                margin:       0.5,
                filename:     'Invoice_<?php echo $order['id']; ?>.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>

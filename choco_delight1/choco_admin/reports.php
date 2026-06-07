<?php
require_once 'config.php';
require_login();

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');
$where = "o.created_at BETWEEN ? AND ?";
$stmt = $mysqli->prepare("SELECT o.id,o.created_at,o.total,c.name FROM orders o LEFT JOIN customers c ON o.customer_id=c.id WHERE $where ORDER BY o.created_at DESC");
$stmt->bind_param('ss',$from,$to);
$stmt->execute();
$res = $stmt->get_result();

include 'includes.php';
?>

<!-- Include html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<div class="card">
  <h2>Generate Report</h2>
  <form method="get" style="display:flex;gap:8px;align-items:end">
    <div><label>From</label><input type="date" name="from" value="<?php echo e($from); ?>"></div>
    <div><label>To</label><input type="date" name="to" value="<?php echo e($to); ?>"></div>
    <div><button class="btn" type="submit">Run</button></div>
    <!-- PDF Button -->
    <div><button class="btn" type="button" onclick="generatePDF()" style="background:#dc3545">Download PDF</button></div>
  </form>

  <div id="report-content" style="padding:10px; background:#fff;">
      <h3 style="text-align:center; margin-bottom:20px;">Sales Report (<?php echo e($from); ?> to <?php echo e($to); ?>)</h3>
      <table style="margin-top:12px; width:100%; border-collapse:collapse;" border="1" cellpadding="5">
        <thead>
            <tr style="background:#f4f4f4;">
                <th>Order ID</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
          <?php $total = 0; while($r = $res->fetch_assoc()): $total += $r['total']; ?>
          <tr>
            <td><?php echo e($r['id']); ?></td>
            <td><?php echo e($r['created_at']); ?></td>
            <td><?php echo e($r['name']); ?></td>
            <td>₹ <?php echo e($r['total']); ?></td>
          </tr>
          <?php endwhile; ?>
          <tr style="background:#fafafa;">
              <td colspan="3" style="text-align:right"><strong>Grand Total</strong></td>
              <td><strong>₹ <?php echo e(number_format($total,2)); ?></strong></td>
          </tr>
        </tbody>
      </table>
      
      <p style="text-align:center; font-size:12px; color:#aaa; margin-top:20px;">Generated on <?php echo date('Y-m-d H:i:s'); ?></p>
  </div>
</div>

<script>
    function generatePDF() {
        const element = document.getElementById('report-content');
        const opt = {
            margin:       0.5,
            filename:     'Sales_Report_<?php echo $from; ?>_to_<?php echo $to; ?>.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2pdf:     { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>

<?php include 'footer.php'; ?>

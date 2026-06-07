<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require_once 'config.php';

$cat = intval($_GET['cat'] ?? 0);
$data = [];

if ($cat) {
    $res = $mysqli->prepare("SELECT id, name FROM subcategories WHERE category_id=? ORDER BY name");
    $res->bind_param('i',$cat);
    $res->execute();
    $data = $res->get_result()->fetch_all(MYSQLI_ASSOC);
}

header('Content-Type: application/json');
echo json_encode($data);

<?php
include('../config/conn.php');
session_start();

if (!isset($_SESSION['User_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['User_id'];

// ✅ REMOVE one product
if (isset($_POST['remove'])) {
    $pid = (int)$_POST['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE User_id = '$user_id' AND P_id = '$pid'");
}

// ✅ UPDATE one product
elseif (isset($_POST['update_one'])) {
    $pid = (int)$_POST['update_one'];
    $qty = max(1, (int)$_POST['quantities'][$pid]);
    mysqli_query($conn, "UPDATE cart SET Cart_quantity = '$qty' WHERE User_id = '$user_id' AND P_id = '$pid'");
}

// ✅ UPDATE all products
elseif (isset($_POST['quantities'])) {
    foreach ($_POST['quantities'] as $pid => $qty) {
        $pid = (int)$pid;
        $qty = max(1, (int)$qty);
        mysqli_query($conn, "UPDATE cart SET Cart_quantity = '$qty' WHERE User_id = '$user_id' AND P_id = '$pid'");
    }
}

header("Location: shopping-cart.php");
exit;
?>

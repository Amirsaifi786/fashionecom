<?php
session_start();
include('../config/conn.php');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION['User_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['User_id'];

// Fetch cart items
$cart_sql = "SELECT cart.*, product.P_name, product.P_price 
             FROM cart 
             JOIN product ON cart.P_id = product.P_id 
             WHERE cart.User_id = '$user_id'";
$cart_result = mysqli_query($conn, $cart_sql);

if (mysqli_num_rows($cart_result) == 0) {
    echo "<script>alert('Your cart is empty.'); window.location.href='shopping-cart.php';</script>";
    exit;
}

// Prepare order summary
$order_des = "";
$total = 0;
$cart_items = []; // store for later use in order_details

while ($row = mysqli_fetch_assoc($cart_result)) {
    $name = $row['P_name'];
    $qty = $row['Cart_quantity'];
    $price = $row['P_price'];
    $subtotal = $qty * $price;
    $total += $subtotal;
    $order_des .= "$name (Qty: $qty, ₹$price), ";

    $cart_items[] = [
        'P_id' => $row['P_id'],
        'quantity' => $qty,
        'amount' => $subtotal
    ];
}

$order_des = rtrim($order_des, ', ');
$order_date = date("Y-m-d");
$payment_status = 'Pending';
$order_status = 'Processing';

// Insert into order table
$order_sql = "INSERT INTO `order` (Order_des, Order_date, Payment_status, User_id, Order_status)
              VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $order_sql);
mysqli_stmt_bind_param($stmt, "sssds", $order_des, $order_date, $payment_status, $user_id, $order_status);

if (mysqli_stmt_execute($stmt)) {
    $order_id = mysqli_insert_id($conn); // Get newly created Order ID

    // Insert each item into order_details
    foreach ($cart_items as $item) {
        

        $detail_sql = "INSERT INTO order_details (Quantity, Order_id, P_id, Amount) 
                       VALUES (?, ?, ?, ?)";
        $detail_stmt = mysqli_prepare($conn, $detail_sql);
        mysqli_stmt_bind_param($detail_stmt, "iiid", 
            $item['quantity'], $order_id, $item['P_id'], $item['amount']);
        mysqli_stmt_execute($detail_stmt);
    }

    // Clear cart
    mysqli_query($conn, "DELETE FROM cart WHERE User_id = '$user_id'");

    echo "<script>alert('Order placed successfully!'); window.location.href='thankyou.php';</script>";
} else {
    echo "<script>alert('Something went wrong. Please try again.'); window.location.href='checkout.php';</script>";
}
?>


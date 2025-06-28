<?php
// session_start();
// require_once("../config/conn.php");

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $user_id = $_POST['user_id']; // Or use $_SESSION['User_id']
//     $product_id = $_POST['product_id'];
//     $quantity = $_POST['quantity'];
//     $price = $_POST['price'];
//     $date = date("Y-m-d");

//     // Optional: check if already in cart
//     $check = mysqli_query($conn, "SELECT * FROM cart WHERE User_id='$user_id' AND P_id='$product_id'");
//     if (mysqli_num_rows($check) > 0) {
//         // Update quantity
//         mysqli_query($conn, "UPDATE cart SET Cart_quantity = Cart_quantity + $quantity WHERE User_id='$user_id' AND P_id='$product_id'");
//     } else {
//         // Insert new
//         $sql = "INSERT INTO cart (Cart_date, User_id, P_id, Cart_quantity, Cart_price) 
//                 VALUES ('$date', '$user_id', '$product_id', '$quantity', '$price')";
//         mysqli_query($conn, $sql);
//     }

//     header("Location: shopping-cart.php"); // Redirect to cart page
//     exit;
// }

?>
<?php
session_start();
require_once("../config/conn.php");

// User not logged in
if (!isset($_SESSION['User_id'])) {
    echo "
    <html>
    <head>
        <title>Login Required</title>
        <!-- Include SweetAlert CSS and JS -->
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Login Required',
                text: 'You must be logged in to add items to your cart.',
                confirmButtonText: 'Go Back'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back(); // Or window.location.href = 'login.php';
                }
            });
        </script>
    </body>
    </html>
    ";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['User_id'];
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $date = date("Y-m-d");

    $check = mysqli_query($conn, "SELECT * FROM cart WHERE User_id='$user_id' AND P_id='$product_id'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "UPDATE cart SET Cart_quantity = Cart_quantity + $quantity WHERE User_id='$user_id' AND P_id='$product_id'");
    } else {
        $sql = "INSERT INTO cart (Cart_date, User_id, P_id, Cart_quantity, Cart_price) 
                VALUES ('$date', '$user_id', '$product_id', '$quantity', '$price')";
        mysqli_query($conn, $sql);
    }

    header("Location: shopping-cart.php");
    exit;
}
?>



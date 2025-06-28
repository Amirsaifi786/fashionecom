<?php
include 'header.php';
// Initialize variables
$nameErr = $emailErr = $passwordErr = $confirm_passwordErr = "";
$name = $email = $password = $confirm_password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = trim($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = trim($_POST["email"]);
        // Check if email already exists
        $check = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");
        if (mysqli_num_rows($check) > 0) {
            $emailErr = "Email already exists";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST["password"];
    }

    if (empty($_POST["confirm_password"])) {
        $confirm_passwordErr = "Confirm Password is required";
    } else {
        $confirm_password = $_POST["confirm_password"];
        if ($password !== $confirm_password) {
            $confirm_passwordErr = "Passwords do not match";
        }
    }

    // If no errors, register the user
    if (empty($nameErr) && empty($emailErr) && empty($passwordErr) && empty($confirm_passwordErr)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO user (User_name, Email, Password, Is_admin) 
                VALUES ('$name', '$email', '$hashedPassword', 0)";
        if (mysqli_query($conn, $sql)) {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful',
                text: 'You can now log in!',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = 'login.php';
            });
            </script>";
            exit;
        } else {
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: 'Something went wrong!',
                confirmButtonText: 'OK'
            });
            </script>";
        }
    }
}
?>

<!-- Registration Form -->
<div id="app">
  <section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="card card-primary">
            <div class="card-header">
              <h4>Register</h4>
            </div>
            <div class="card-body">
              <form method="POST" action="" class="needs-validation" novalidate="">
                <div class="form-group">
                  <label for="name" class="control-label">Name</label>
                  <input id="name" type="text" class="form-control" name="name" required value="<?php echo htmlspecialchars($name); ?>">
                  <span class="text-danger"><?php echo $nameErr; ?></span>
                </div>

                <div class="form-group">
                  <label for="email">Email</label>
                  <input id="email" type="email" class="form-control" name="email" required value="<?php echo htmlspecialchars($email); ?>">
                  <span class="text-danger"><?php echo $emailErr; ?></span>
                </div>

                <div class="form-group">
                  <label for="password" class="control-label">Password</label>
                  <input id="password" type="password" class="form-control" name="password" required>
                  <span class="text-danger"><?php echo $passwordErr; ?></span>
                </div>

                <div class="form-group">
                  <label for="confirm_password" class="control-label">Confirm Password</label>
                  <input id="confirm_password" type="password" class="form-control" name="confirm_password" required>
                  <span class="text-danger"><?php echo $confirm_passwordErr; ?></span>
                </div>

                <div class="float-left">
                  <a href="forgotpassword.php" class="text-small">Forgot Password?</a>
                </div>
                <div class="float-right">
                  <a href="resetpassword.php" class="text-small">Reset Password?</a>
                </div>

                <div class="card-footer text-right">
                  <button class="btn btn-primary" type="submit">Register</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include 'footer.php'; ?>
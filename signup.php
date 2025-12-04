<?php
session_start();
require_once("inc/conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Voting - Signup</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

  <div class="col-md-5">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">Signup</h4>
      </div>
      <div class="card-body">
        <form method="post" novalidate>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter fullname" required>
          </div>

          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" 
                   placeholder="Enter password" required
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                   title="Password must be at least 8 characters, include uppercase, lowercase, number, and special character.">
            <div class="form-text">Must be 8+ chars, with uppercase, lowercase, number, and special character.</div>
          </div>

          <div class="mb-3">
            <label for="confirmpassword" class="form-label">Confirm Password</label>
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" 
                   placeholder="Confirm password" required>
          </div>

          <button type="submit" name="signup" class="btn btn-success w-100">Sign Up</button>
        </form>
      </div>
      <div class="card-footer text-center">
        <small>Already have an account? <a href="index.php" class="text-primary fw-bold">Login here</a></small>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
require_once("inc/conn.php");  // your DB connection

if (isset($_POST['signup'])) {
    $username       = trim($_POST['username']);
    $fullname       = trim($_POST['fullname']);
    $password       = $_POST['password'];
    $cpassword      = $_POST['confirmpassword'];

    // server-side password strength check
    $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';
    if (!preg_match($pattern, $password)) {
        echo "<script>alert('Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.');</script>";
    }
    else if ($password !== $cpassword) {
        echo "<script>alert('Passwords do not match');</script>";
    }
    else {
        // hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // use prepared statements to insert user
        $stmt = $conn->prepare("INSERT INTO users (user_name, password) VALUES (?, ?)");
        if ($stmt === false) {
            // statement prep failed
            error_log("Prepare failed: " . $conn->error);
            echo "<script>alert('Something went wrong. Please try again later.');</script>";
        } else {
            $stmt->bind_param("ss", $username, $hashed);
            $exec1 = $stmt->execute();
            if ($exec1) {
                $user_id = $stmt->insert_id;
                $stmt->close();

                // now insert into voters (or votters?) table
                $stmt2 = $conn->prepare("INSERT INTO votters (fullname, user_id) VALUES (?, ?)");
                if ($stmt2 === false) {
                    error_log("Prepare failed (votters): " . $conn->error);
                    echo "<script>alert('Something went wrong. Please try again later.');</script>";
                } else {
                    $stmt2->bind_param("si", $fullname, $user_id);
                    $exec2 = $stmt2->execute();
                    if ($exec2) {
                        echo "<script>alert('Registration Successful'); location.href='index.php';</script>";
                    } else {
                        error_log("Execute failed (votters): " . $stmt2->error);
                        echo "<script>alert('Registration failed, please try again');</script>";
                    }
                    $stmt2->close();
                }
            } else {
                // maybe username already exists or other DB error
                error_log("Execute failed (users): " . $stmt->error);
                echo "<script>alert('Registration failed, please try again');</script>";
            }
        }
    }
}
?>

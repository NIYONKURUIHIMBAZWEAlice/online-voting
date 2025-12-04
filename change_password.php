<?php
session_start();
require_once("inc/conn.php");
            $nextpage=$_SESSION["user"]["role"]=="ADMIN"?"admin_home.php":"votter_home.php";

// Ensure user is logged in
if(!isset($_SESSION['user'])){
    echo "<script>alert('You must login first'); location.href='index.php';</script>";
    exit();
}

if(isset($_POST['change'])){
    $current = $_POST['current_password'];
    $new     = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    $user_id = $_SESSION["user"]['user_id'];

    // Fetch current password hash
    $result = mysqli_query($conn, "SELECT password FROM users WHERE user_id='$user_id'");
    $row = mysqli_fetch_assoc($result);

    if(!$row || !password_verify($current, $row['password'])){
        echo "<script>alert('Current password is incorrect');</script>";
    } elseif($new !== $confirm){
        echo "<script>alert('New passwords do not match');</script>";
    } else {
        // Hash new password
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $update = "UPDATE users SET password='$hashed' WHERE user_id='$user_id'";
        if(mysqli_query($conn, $update)){
            echo "<script>alert('Password changed successfully'); location.href='$nextpage';</script>";
        } else {
            echo "<script>alert('Failed to change password');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

  <div class="col-md-5">
    <div class="card shadow-lg border-0">
      <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">🔒 Change Password</h4>
      </div>
      <div class="card-body">
        <form method="post" novalidate>
          <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Enter current password" required>
          </div>

          <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" 
                   placeholder="Enter new password" required
                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{8,}$"
                   title="Must be 8+ chars, include uppercase, lowercase, number, and special character.">
            <div class="form-text">At least 8 characters, with uppercase, lowercase, number, and special character.</div>
          </div>

          <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm new password" required>
          </div>

          <button type="submit" name="change" class="btn btn-success w-100">Update Password</button>
        </form>
      </div>
      <div class="card-footer text-center">
        <small><a href="<?=$nextpage?>" class="text-primary fw-bold">Back to Dashboard</a></small>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

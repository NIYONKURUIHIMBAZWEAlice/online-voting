<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Voting</title>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items:center;
      min-height:100vh;
      background-color: lightskyblue;
    }
    form {
      background-color: white;
      width: 500px;
      height: auto;  
      border-radius: .2rem;
      padding:2rem;
    }
    input, button {
      width: 100%;
      min-height: 1.5rem;
      padding: .5rem;
      outline: none;
      border: solid 1px;
    }
    button {
      margin: 0;
      background-color: blue;
      color:white;
      font-weight: bold;
    }
    form div {
      margin-block: .5rem;
    }
    .register-link {
      text-align: center;
      margin-top: 1rem;
    }
    .register-link a {
      color: blue;
      text-decoration: none;
      font-weight: bold;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <form action="app.php" method="post">
    <?php
    if(isset($_SESSION["error"])){
        ?>
        <div class="err" style="color:red">
            <span>Error</span>:
            <span><?=$_SESSION["error"]?>!</span>
        </div>
    <?php
    unset($_SESSION["error"]);
    }
    ?>
    <h1>Login</h1>
    <div>
      <input type="text" name="username" placeholder="Enter Username" required>
    </div>
    <div>
      <input type="password" name="password" placeholder="Enter Password" required>
    </div>
    <div>
      <button type="submit" name="login">Login</button>
    </div>

    <!-- Register link -->
    <div class="register-link">
      <p>Don't have an account? <a href="signup.php">Register here</a></p>
    </div>
  </form>
</body>
</html>

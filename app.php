
<?php

//////////  Login ///////////
session_start();
require_once("inc/conn.php");
if(isset($_POST['login'])){
    // get users in put
    $username=$_POST['username'];
    $password=$_POST['password'];

    $query= "SELECT * FROM users WHERE `user_name` ='$username'";
    $sql=mysqli_query($conn,$query);
    
    if(mysqli_num_rows($sql)>0){

        $user= mysqli_fetch_array($sql);
        if(password_verify($password,$user["password"])){
            $_SESSION["user"]=$user;

            if($user["role"]=="ADMIN"){
                header("location:admin_home.php");
            }
            else{
                header("location:votter_home.php");
            }
        }else{
            $_SESSION["error"]="invalid password";
            header("location:index.php");
        }
    }else{
       $_SESSION["error"]="User does not exist";
        
       header("location:index.php");
    }
    
}


?>
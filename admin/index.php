<?php
include 'connect.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register & Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
				
     <div class="container" id="signIn">
        <h1 class="form-title">PustakaLaya</h1>
        <form method="post" action="">
          <div class="input-group">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email" required>
              <label for="email">Email</label>
          </div>
          <div class="input-group">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Password" required>
              <label for="password">Password</label>
          </div>
          <p class="recover">
            <a href="..\user/index.php">User Login</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
         <!-------------------- php ----------------------------->
            <?php 
                if(isset($_POST['signIn'])){
                $email=$_POST['email'];
                $password=$_POST['password'];
                $password=md5($password) ;
                
                $sql="SELECT * FROM admins WHERE email='$email' and password='$password'";
                $result=$conn->query($sql);
                if($result->num_rows>0){
                    session_start();
                    $row=$result->fetch_assoc();
                    $_SESSION['email']=$row['email'];
                    $_SESSION['id']=$row['id'];
                    header("Location: admin_dashboard.php");
                    exit();
                }
                else{
                    ?>
                    <br><center><span style="color: red;">Not Found, Incorrect Email or Password</span></center>
                    <?php
                }

                }
            ?>
       </div>
</body>
</html>


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
  <!-- **********************Register page********************************** -->
    <div class="container" id="signup" style="display:none;">
      <h1 class="form-title">Register Pustakalaya</h1>
      <form method="post" action="">
        <div class="input-group">
           <i class="fas fa-user"></i>
           <input type="text" name="name" id="name" placeholder="Name" required>
           <label for="name">Name</label>
        </div>
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
        <div class="input-group">
            <i class="fas fa-mobile"></i>
            <input type="number" name="mobile" id="mobile" placeholder="mobile" required>
            <label for="mobile">Mobile</label>
        </div>
        <div class="input-group">
            <i class="fas fa-location"></i>
            <input type="text" name="address" id="address" placeholder="address" required>
            <label for="address">Address</label>
        </div>
       <input type="submit" class="btn" value="Sign Up" name="signUp">
      </form>
      
      <div class="links">
        <p>Already Have Account ?</p>
        <button id="signInButton">Sign In</button>
      </div>
    </div>

    <!-- ***********************Signin Page***********************************************88 -->
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
            <a href="..\admin/index.php">Admin Login</a>
          </p>
         <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        
        <div class="links">
          <p>Don't have account yet?</p>
          <button id="signUpButton">Sign Up</button>
        </div>
              <!--------------------------------------php ----------------------------------------------->
              <?php 
                if(isset($_POST['signUp'])){
                    $Name=$_POST['name'];
                    $email=$_POST['email'];
                    $password=$_POST['password'];
                    $password=md5($password);
                    $mobile=$_POST['mobile'];
                    $address=$_POST['address'];

                    $checkEmail="SELECT * From users where email='$email'";
                    $result=$conn->query($checkEmail);
                    if($result->num_rows>0){
                        echo "Email Address Already Exists !";
                    }
                    else{
                        $insertQuery="INSERT INTO users(name,email,password,mobile,address)
                                    VALUES ('$Name','$email','$password','$mobile','$address')";
                            if($conn->query($insertQuery)==TRUE){
                                header("location: index.php");
                            }
                            else{
                                echo "Error:".$conn->error;
                            }
                    }
                

                }

                if(isset($_POST['signIn'])){
                $email=$_POST['email'];
                $password=$_POST['password'];
                $password=md5($password) ;
                
                $sql="SELECT * FROM users WHERE email='$email' and password='$password'";
                $result=$conn->query($sql);
                if($result->num_rows>0){
                    session_start();
                    $row=$result->fetch_assoc();
                    $_SESSION['name']=$row['name'];
                    $_SESSION['email']=$row['email'];
                    $_SESSION['id']=$row['id'];
                    $_SESSION['mobile']=$row['mobile'];
                    $_SESSION['address']=$row['address'];
                    
                    header("Location: user_dashboard.php");
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

      <script src="script.js"></script>
</body>
</html>


<?php 
include 'connect.php';

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
    <br><br><center><span class="alert-danger">Wrong Password !!</span></center>
    <?php
   }

}
?>
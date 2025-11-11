<?php
	include 'connect.php';
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Author</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
	<link rel="stylesheet" href="../css/admin_view.css">
</head>
<body>
   <!--  -->
   <nav class="header">
        <a href="#" class="logo">Pustakalaya</a>
        <ul class="main-nav">
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="#">Book</a>
                <ul class="sub-nav">
                    <li><a href="register_book.php">Registered New Book</a></li>
                    <li><a href="manage_book.php">Manage Book</a></li>
                    <li><a href="book_issue.php">Issue Book</a></li>
                    <li><a href="book_return.php">Return Book</a></li>
                </ul>
            </li>
            <li><a href="#">Author</a>
                <ul class="sub-nav">
                    <li><a href="add_author.php">Add New Author</a></li>
                    <li><a href="manage_author.php">Manage Author</a></li>
                </ul>
            </li>
            <li><a href="profile.php">Profile</a>
            </li>
        </ul>
    </nav>

 <!-- Main Content Section -->
  <center>
                <div style="width: 300px">
                <h2 style="text-align: center; padding: 20px;">Add Author</h2>
                    <form method="POST">
                        <div class="form-group">
                            <i class="fas fa-user"></i>
                            <input type="text" name="author_name" id="name" placeholder="Name" required>
                        </div>
                        <input type="submit" class="btn" value="Add Author" name="add_author">
                        <!-- php -->
                <?php
                    if(isset($_POST['add_author']))
                    {  
                        $author_name = $_POST['author_name'];
                        $checkname ="SELECT * From authors where author_name='$author_name'";
                    $result=$conn->query($checkname);
                    if($result->num_rows>0){
                        ?>
                        <br><br><center><span style="color: red;"><?php echo $_POST['author_name'];?> is already registered.</span></center>
                        <?php
                        }else{
                            $connection = mysqli_connect("localhost","root","");
                            $db = mysqli_select_db($connection,"pustakalayaa");
                            $query = "insert into authors values(null,'$_POST[author_name]')";
                            $query_run = mysqli_query($connection,$query);
                            echo " <script>alert('$author_name has registered successfully!');</script>";
                                    
                        }
                    }
                ?>
            <!--  -->
                    </form>
                </div>
    </center>
  
</body>
</html>

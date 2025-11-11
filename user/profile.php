<?php
	session_start();
	function get_user_issue_book_count(){
		$connection = mysqli_connect("localhost","root","");
		$db = mysqli_select_db($connection,"pustakalayaa");
		$user_issue_book_count = 0;
		$query = "select count(*) as user_issue_book_count from issued_books where student_id = $_SESSION[id]";
		$query_run = mysqli_query($connection,$query);
		while ($row = mysqli_fetch_assoc($query_run)){
			$user_issue_book_count = $row['user_issue_book_count'];
		}
		return($user_issue_book_count);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">
    <link rel="stylesheet" href="../css/admin_del.css">
</head>
<body>
    <!--  -->
    <nav class="header">
        <a href="#" class="logo">Pustakalaya</a>
        <ul class="main-nav">
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="view_book.php">Book</a>
                <!-- <ul class="sub-nav">
                    <li><a href="book_issue.php">Issue Book</a></li>
                    <li><a href="book_return.php">Return Book</a></li>
                </ul> -->
            </li>
            <li><a href="profile.php">Profile</a>
            </li>
        </ul>
    </nav>
	<!--  -->
	
        <<!--  -->
<h2 style="text-align: center; padding:20px ">User Profile Detail</h2>

<div class="profile-container">
    <h2>User Details</h2>
    <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
    <p><strong>Phone:</strong> <?php echo $_SESSION['mobile']; ?></p>
    <p><strong>Address:</strong> <?php echo $_SESSION['address']; ?></p>
    <p><a href="logout.php" class="delet">Logout</a></p>
</div>

</body>
</html>
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
    <link rel="stylesheet" href="../css/admin_dashboard.css">

</head>
<body>
    <!--  -->
    <nav class="header">
        <a href="#" class="logo">Pustakalaya</a>
        <ul class="main-nav">
            <li><a href="user_dashboard.php">Home</a></li>
            <li><a href="view_book.php">Book</a>
                <!-- <ul class="sub-nav">
                    <li><a href="view_book.php">View Book</a></li>
                    <li><a href="book_issue.php">Issue Book</a></li>
                </ul> -->
            </li>
            <li><a href="profile.php">Profile</a>
            </li>
        </ul>
    </nav>
	<!--body part  -->
	
        <div class="container">
        <!-- total User -->
            <div class="issued">
                <div style="margin: 25px">
                    <div style="width: 300px">
                        <h3>Book Issued</h3>
                        <div>
                        <p class="card-text">No of book issued: <?php echo get_user_issue_book_count();?></p>
                        <div class="btn"><a class="vib" href="view_issued_book.php">View Issued Books</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
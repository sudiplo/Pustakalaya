<?php
	require("functions.php");
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_dashboard.css">

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
	<!--  -->
    <div class="container">
        <!-- total User -->
        <div class="issued">
            <div style="margin: 25px">
                <div style="width: 300px">
                    <h3>Registered User</h3>
                    <div>
                    <p class="card-text">No. total Users: <?php echo get_user_count();?></p>
                    <div class="btn"><a class="vib" href="view_user.php">Registered Users</a></div>
                    </div>
                </div>
            </div>
        </div>
        <!--  total books-->
        <div class="issued">
            <div style="margin: 25px">
                <div style="width: 300px">
                    <h3>Registered Books</h3>
                    <div>
                    <p class="card-text">No. of Registered Books : <?php echo get_book_count();?></p>
                    <div class="btn"><a class="vib" href="view_book.php">View All Books</a></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- total authors-->
        <div class="issued">
            <div style="margin: 25px">
                <div style="width: 300px">
                    <h3>Registered Authors</h3>
                    <div>
                        <p class="card-text">No. total Authors: <?php echo get_author_count();?></p>
                        <div class="btn"><a class="vib" href="view_author.php">View Authors</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        
    </div>
    <!--  -->
    <div class="container">
        <div class="issued">
            <div style="margin: 25px">
                <div style="width: 300px">
                    <h3>Book Issued</h3>
                    <div>
                    <p class="card-text">No. of book issued: <?php echo get_issue_book_count();?></p>
                    <div class="btn"><a class="vib" href="view_issued_book.php">Issued Books</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!--  -->
        
</body>
</html>

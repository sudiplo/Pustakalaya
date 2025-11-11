<?php
	require("functions.php");
	session_start();
	#fetch data from database
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"pustakalayaa");
	$name = "";
	$email = "";
	$mobile = "";
	$query = "select * from admins where email = '$_SESSION[email]'";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
		$name = $row['name'];
		$email = $row['email'];
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_manage.css">
	<link rel="stylesheet" href="../css/admin_del.css">

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
	
		<center><h2 style="text-align: center; padding: 20px;">Manage Books</h2></center>
        
		<table>
			<thead>
				<tr>
                    <th>Book ID</th>
					<th>Name</th>
					<th>Author</th>
					<th>Stock</th>
                    <th>Action</th>
				</tr>
	    		</thead>
			<?php
				$connection = mysqli_connect("localhost","root","");
				$db = mysqli_select_db($connection,"pustakalayaa");
				$query = "select * from books";
				$query_run = mysqli_query($connection,$query);
				while ($row = mysqli_fetch_assoc($query_run)){
					?>
					<tr>
						<td><?php echo $row['book_id'];?></td>
						<td><?php echo $row['book_name'];?></td>
						<td><?php echo $row['author_name'];?></td>
						<td><?php echo $row['stock'];?></td>
						<td>
						<a href="edit_book.php?bn=<?php echo $row['book_id'];?>" class="renew">Edit</a>
						<a href="delete_book.php?bn=<?php echo $row['book_id'];?>" class="delet">Delete</a></td>

                       
					</tr>
					<?php
				}
			?>
		</table>
</body>
</html>

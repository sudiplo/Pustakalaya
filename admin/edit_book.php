<?php
include 'connect.php';
	session_start();
	#fetch data from database
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"pustakalayaa");
	$book_id = "";
	$book_name = "";
	$author_name = "";
	$stock = "";
	$query = "select * from books where book_id = $_GET[bn]";
	$query_run = mysqli_query($connection,$query);
	while ($row = mysqli_fetch_assoc($query_run)){
        $book_id = $row['book_id'];
		$book_name = $row['book_name'];
		$author_name = $row['author_name'];
		$stock = $row['stock'];
		
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

    <!-- edit book -->
        <center><h2 style="text-align: center; padding: 20px;">Edit Books</h2></center>
				<form action="" method="post">
					<div class="form-group">
						<label for="email">Book Name:</label>
						<input type="text" name="book_name" value="<?php echo $book_name;?>" class="form-control" required>
					</div>
                    <div class="form-group">
                        <label for="book_author">Author:</label>
                        <select class="form-control" name="author_name">
                            <option required>-Select author-</option>
                            <?php  
                                $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                                $query = "SELECT author_name FROM authors";
                                $query_run = mysqli_query($connection, $query);
                                while($row = mysqli_fetch_assoc($query_run)) {
                            ?>
                                <option><?php echo $row['author_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
					<div class="form-group">
						<label for="mobile">stock :</label>
						<input type="number" name="stock" value="<?php echo $stock;?>" class="form-control" min="0" required>
					</div>
					<button type="submit" name="update" class="renew">Update Book</button>
				</form>
</body>
</html>
<?php
	if (isset($_POST['update'])) {
        $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");

        if (!$connection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $book_name = mysqli_real_escape_string($connection, $_POST['book_name']);
        $author_name = mysqli_real_escape_string($connection, $_POST['author_name']);
        $stock = mysqli_real_escape_string($connection, $_POST['stock']);
        $book_id = mysqli_real_escape_string($connection, $_GET['bn']);  

        $query = "UPDATE books SET book_name = ?, author_name = ?, stock = ? WHERE book_id = ?";

        if ($stmt = mysqli_prepare($connection, $query)) {
            mysqli_stmt_bind_param($stmt, "ssii", $book_name, $author_name, $stock, $book_id);
    

            if (mysqli_stmt_execute($stmt)) {

                header("Location: manage_book.php");
                exit();
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
    

            mysqli_stmt_close($stmt);
        } else {
            echo "Error preparing statement: " . mysqli_error($connection);
        }
        mysqli_close($connection);
    }
    
    

    
	

?>
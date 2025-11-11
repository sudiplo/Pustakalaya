
<?php
session_start();
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,"pustakalayaa");
$author_id = "";
$author_name = "";
$query = "select * from authors ";
$result = mysqli_query($connection,$query);
$query_run = mysqli_query($connection, $query);

if (!$query_run) {
    die('Query failed: ' . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
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
    <h2 style="text-align: center; padding: 20px;">Registered Authors</h2>

    <!-- table -->
    <table width="900px" style="text-align: center" >
        <tr>
            <th>Author ID</th>
            <th>Author Name</th>
        </tr>

            <?php
                while ($row = mysqli_fetch_assoc($query_run)) {
            ?>
        <tr>
            <td><?php echo $row['author_id']; ?></td>
            <td><?php echo $row['author_name']; ?></td>
        </tr>
            <?php
                }
            ?>
    </table>

</body>
</html>


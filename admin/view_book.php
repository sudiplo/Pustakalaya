<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "pustakalayaa");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$book_name = "";
$author = "";
$category = "";
$book_no = "";

$query = "SELECT * FROM books";

$query_run = mysqli_query($connection, $query);

if (!$query_run) {
    die('Query failed: ' . mysqli_error($connection));
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Reg Books</title>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
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

    <h2 style="text-align: center; padding: 20px; ">Registered Book's Detail</h2>
            <table class="table-bordered" width="900px" style="text-align: center" >
                <tr>
                    <th>Book ID</th>
                    <th>Name</th>
                    <th>Author</th>
                    <th>Stock</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($query_run)) {
                    ?>
                    <tr>
                        <td><?php echo $row['book_id']; ?></td>
                        <td><?php echo $row['book_name']; ?></td>
                        <td><?php echo $row['author_name']; ?></td>
                        <td><?php echo $row['stock']; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
 
    <!--  -->
</div>
</body>
</html>

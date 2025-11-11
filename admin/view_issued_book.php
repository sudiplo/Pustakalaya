
<?php
session_start();
$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"pustakalayaa");
$book_no = "";
$book_name = "";
$student_id = "";
$query = "select * from issued_books ";
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
    <h2 style="text-align: center; padding: 20px; ">Issued Books</h2>
            <table class="table-bordered" width="900px" style="text-align: center" >
                <tr>
                    <th>Student Id</th>
                    <th>Student Name</th>
                    <th>Book Name</th>
                    <th>Book Auther</th>
                    <th>Issue Date</th>
                    <th>Return Date</th>
                    <th>Fine</th>
                </tr>

                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $student_id = $row['student_id'];
                        $book_id = $row['book_id'];
                        $book_author = $row['book_author'];
                        $issue_date = $row['issue_date'];
                        $renewal_date = $row['renewal_date'];

                        $overdue_days = (strtotime($renewal_date) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
                        if ($overdue_days < 0) {
                            $overdue_days = abs($overdue_days);
                            $fine_amount = (int)$overdue_days * 2;  
                                              
                        } else {
                            $overdue_days = 0;
                            $fine_amount = 0;
                        }

                    ?>
                        <td><?php echo $student_id; ?></td>
                        <!--------to print student name ------------------ -->
                        <?php
                            $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                            $query = "SELECT name FROM users WHERE id = '$student_id'";
                            $query_run = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($query_run)) {?>
                            <td><?php echo $row['name']; 
                        ?></td>
                        <?php }?>
                         <!--------to print book name ------------------ -->
                         <?php
                            $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                            $query = "SELECT book_name FROM books WHERE book_id = '$book_id'";
                            $query_run = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($query_run)) {?>
                            <td><?php echo $row['book_name']; 
                        ?></td>
                        <?php }?>

                        <td><?php echo $book_author; ?></td>
                        <td><?php echo $issue_date; ?></td>
                        <td><?php echo $renewal_date; ?></td>
                        <td><?php echo "Rs ".$fine_amount; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

</body>
</html>


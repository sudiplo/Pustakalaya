<?php
include 'connect.php';
session_start();
// renew
if (isset($_GET['s_no'])) {
    $s_no = $_GET['s_no'];  

  
    $sql = "UPDATE issued_books 
            SET renewal_date = CURDATE() + INTERVAL 15 DAY 
            WHERE s_no = ?";


    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $s_no);  
        $stmt->execute();  

        
        if ($stmt->affected_rows > 0) {
            // echo "<p>Book renewed successfully!</p>";
            echo " <script>alert('Book renewed successfully!');</script>";
        } else {
            // echo "<p>Failed to renew the book. Please try again.</p>";
            echo " <script>alert('Failed to renew the book. Please try again.');</script>";
        }

        $stmt->close(); 
    } else {
        // echo "<p>Error: Could not prepare the query.</p>";
        echo " <script>alert('Error: Could not prepare the query.');</script>";
    }
} else {
    // // echo "<p>Invalid request. No book selected for renewal.</p>";
    // echo " <script>alert('Invalid request. No book selected for renewal.');</script>";
}

// 
$user_id = $_SESSION['id'];

$sql = "SELECT ib.s_no, ib.book_id, ib.book_author, ib.issue_date, ib.renewal_date
        FROM issued_books ib
        JOIN users u ON u.id = ib.student_id
        WHERE u.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);  
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
    <link rel="stylesheet" href="../css/admin_view.css">
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
                    <li><a href="view_book.php">View Book</a></li>
                    <li><a href="book_issue.php">Issue Book</a></li>
                </ul> -->
            </li>
            <li><a href="profile.php">Profile</a>
            </li>
        </ul>
    </nav>
	<!--body part  -->


    <h2 style="text-align: center;">My Issued Books</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table class="table-bordered" width="900px" style="text-align: center">
            <thead>
                <tr>
                    <th>Book Name</th>
                    <th>Author</th>
                    <th>Issue Date</th>
                    <th>Renewal Date</th>
                    <th>Action</th>
                    <th>Fine</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $book_id = $row['book_id'];
                        $book_author = $row['book_author'];
                        $issue_date = $row['issue_date'];
                        $renewal_date = $row['renewal_date'];// Fetch book name from the books table using book_id
                        $book_sql = "SELECT book_name FROM books WHERE book_id = ?";
                        $book_stmt = $conn->prepare($book_sql);
                        $book_stmt->bind_param("i", $book_id);
                        $book_stmt->execute();
                        $book_result = $book_stmt->get_result();

                        $book_name = "";
                        if ($book_result->num_rows > 0) {
                            $book_row = $book_result->fetch_assoc();
                            $book_name = $book_row['book_name'];
                        }

                        $overdue_days = (strtotime($renewal_date) - strtotime(date("Y-m-d"))) / (60 * 60 * 24);
                        if ($overdue_days < 0) {
                            $overdue_days = abs($overdue_days);
                            $fine_amount = (int)$overdue_days * 2;  
                                              
                        } else {
                            $overdue_days = 0;
                            $fine_amount = 0;
                        }

                    ?>
                    <tr>
                        <td><?php echo $book_name; ?></td>
                        <td><?php echo $book_author; ?></td>
                        <td><?php echo $issue_date; ?></td>
                        <td><?php echo $renewal_date; ?></td>
                        <td>
                            <?php if ($overdue_days > 0): ?>
                                <strong class="overdeu" style="color:red" >Overdue by <?php echo $overdue_days; ?> days</strong>
                            <?php else: ?>
                               
                                <div class="reg"><a href="?s_no=<?php echo $row['s_no']; ?>" class="renew">Renew</a></div></center>
                            <?php endif; ?>
                        </td>
                        <td><?php echo "Rs ".$fine_amount; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have not issued any books yet!</p>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>

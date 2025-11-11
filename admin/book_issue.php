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
    
 <!-- Main Content Section -->
<div>
<h2 style="text-align: center; padding:20px ">Issued Book</h2>
<form action="" method="post">
        <div class="form-group">
            <label for="book_name">Book Name:</label>
            <select class="form-control" name="book_name">
                <option>-Select author-</option>
                <?php  
                    $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                    $query = "SELECT book_name FROM books";
                    $query_run = mysqli_query($connection, $query);
                    while($row = mysqli_fetch_assoc($query_run)) {
                ?>
                    <option><?php echo $row['book_name']; ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group">
            <label for="book_author">Author:</label>
            <select class="form-control" name="author_name">
                <option>-Select author-</option>
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
            <label for="student_id">Student ID:</label>
            <input type="text" name="student_id" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="issue_date">Issue Date:</label>
            <input type="text" name="issue_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
        </div>

        <button type="submit" name="issue_book" class="renew">Issue Book</button>
        <!-------------------------------------- php part --------------------------------->
        <?php
            if (isset($_POST['issue_book'])) {
                // Get form inputs
                $book_name = $_POST['book_name'];  // User provides book name
                $author_name = $_POST['author_name'];
                $student_id = $_POST['student_id'];
                $issue_date = $_POST['issue_date'];
                
                // Create database connection
                $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");

                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Check if the book exists in the database by book_name
                $book_query = "SELECT * FROM books WHERE book_name = '$book_name' AND author_name = '$author_name'";
                $book_result = mysqli_query($connection, $book_query);
                
                if (mysqli_num_rows($book_result) > 0) {
                    $book = mysqli_fetch_assoc($book_result);
                    $book_id = $book['book_id'];  // Get book_id from the books table
                    $stock = $book['stock'];
                    
                    // Check if stock is greater than 0
                    if ($stock <= 0) {
                        // echo "Sorry, this book is currently out of stock.";
                        echo "<script>alert('Sorry, this book is currently out of stock.');</script>";
                        
                    } else {
                        // Check if the student ID exists in the users table
                        $student_query = "SELECT * FROM users WHERE id = '$student_id'";
                        $student_result = mysqli_query($connection, $student_query);
                        
                        if (mysqli_num_rows($student_result) > 0) {
                            // Issue the book
                            // Set the renewal date as today's date + 15 days
                            $renewal_date = date('Y-m-d', strtotime('+15 days'));

                            // Insert into issued_books table with book_id
                            $issue_query = "INSERT INTO issued_books (book_id, book_author, student_id, issue_date, renewal_date) 
                            VALUES ('$book_id', '$author_name', '$student_id', '$issue_date', '$renewal_date')";

                            if (mysqli_query($connection, $issue_query)) {
                                // Decrease the stock of the book by 1
                                $new_stock = $stock - 1;
                                $update_book_query = "UPDATE books SET stock = $new_stock WHERE book_id = " . $book_id;
                                mysqli_query($connection, $update_book_query);
                                
                                // echo "Book issued successfully!";
                                echo "<script>alert('Book issued successfully!');</script>";
                            } else {
                                echo "Error issuing the book: " . mysqli_error($connection);
                            }
                        } else {
                            // echo "Invalid student ID! Please enter a valid student ID.";
                            echo "<script>alert('Invalid student ID! Please enter a valid student ID.');</script>";
                            
                        }
                    }
                } else {
                    // echo "Book not found. Please check the book name and author.";
                    echo "<script>alert('Book not found. Please check the book name and author.');</script>";
                }

                // Close connection
                mysqli_close($connection);
            }
            ?>
    </form>
</div>

    
</body>
</html>

<?php
include 'connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book</title>
   <link rel="stylesheet" href="../css/admin_manage.css">
   <link rel="stylesheet" href="../css/admin_del.css">
</head>
<body>
    <!--  -->
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
<h2 style="text-align: center; padding: 20px;">Register New Book</h2>
<form action="" method="post">
        <div class="form-group">
            <label for="book_name">Book Name:</label>
            <input type="text" name="book_name" class="form-control" required>
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
        <button type="submit" name="register_book" class="renew">Register Book</button>
        <!---------------------- php book register ------------------->
        <?php
                    if (isset($_POST['register_book'])) {  
                        $book_name = $_POST['book_name'];
                        $author_name = $_POST['author_name'];
                    

                        $checkname = "SELECT * FROM books WHERE book_name = ?";
                        $stmt = $conn->prepare($checkname);
                        $stmt->bind_param("s", $book_name); //s(string)
                        $stmt->execute();
                        $result = $stmt->get_result();
                    
                        if ($result->num_rows > 0) {
                            echo "<br><br><center><span style='color: red;'>$book_name is already registered.</span></center>";
                        } else {

                            $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                            if (!$connection) {
                                die("Connection failed: " . mysqli_connect_error());
                            }
                    
  
                            $query = "INSERT INTO books (book_name, author_name) VALUES (?, ?)";
                            $stmt = $connection->prepare($query);
                            $stmt->bind_param("ss", $book_name, $author_name); // ss==  both are strings
                    
                            if ($stmt->execute()) {
                                // echo "<br><br><center><span style='color: green;'>$book_name has registered successfully!</span></center>";
                                echo " <script>alert(' $book_name has registered successfully!');</script>";
                            } else {
                                echo "<br><br><center><span style='color: red;'>Error: Could not register book. Please try again.</span></center>";
                            }

                            $stmt->close();
                            $connection->close();
                        }
                    }
                    
                ?>
            <!--  -->
    </form>
</div>

</body>
</html>
<?php

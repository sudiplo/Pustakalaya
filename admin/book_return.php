<?php
$connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// calculate the fine
function calculateFine($issue_date, $renewal_date) {
    $today = date("Y-m-d");
    $issueDate = strtotime($issue_date);
    $renewalDate = strtotime($renewal_date);
    $fine_per_day = 2;

    // 
    if ($renewalDate < strtotime($today)) {
        $overdue_days = (strtotime($today) - $renewalDate) / (60 * 60 * 24);
        return $fine_per_day * $overdue_days;
    }
    return 0;
}

// search by user ID or user name
$user_details = null;
$issued_books = [];
if (isset($_POST['search_user'])) {
    $search_by = $_POST['search_by'];
    $search_value = $_POST['search_value'];

    // search type
    if ($search_by == 'id') {
        //  user_id
        $user_query = "SELECT * FROM users WHERE id = '$search_value'";
    } else {
        // user_name
        $user_query = "SELECT * FROM users WHERE name LIKE '%$search_value%'";
    }

    $user_result = mysqli_query($connection, $user_query);

    if (mysqli_num_rows($user_result) > 0) {
        $user_details = mysqli_fetch_assoc($user_result);

        // book issued to the user
        $issued_query = "SELECT * FROM issued_books WHERE student_id = '{$user_details['id']}'";
        $issued_result = mysqli_query($connection, $issued_query);

        while ($row = mysqli_fetch_assoc($issued_result)) {
            $issued_books[] = $row;
        }
    } else {
        // echo "No user found with this ID or Name.";
        echo " <script>alert('No user found with this ID or Name.');</script>";
    }
}

// (delete issued book)
if (isset($_GET['delete'])) {
    // Sanitize input to prevent SQL injection
    $s_no = intval($_GET['delete']); 

    // Step 1: Retrieve book_id from issued_books before deleting the record
    $query = "SELECT book_id FROM issued_books WHERE s_no = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $s_no);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $book_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($book_id) {
        // Step 2: Get current stock of the book
        $query_stock = "SELECT stock FROM books WHERE book_id = ?";
        $stmt_stock = mysqli_prepare($connection, $query_stock);
        mysqli_stmt_bind_param($stmt_stock, "i", $book_id);
        mysqli_stmt_execute($stmt_stock);
        mysqli_stmt_bind_result($stmt_stock, $stock);
        mysqli_stmt_fetch($stmt_stock);
        mysqli_stmt_close($stmt_stock);

        if ($stock !== null) {
            // Step 3: Increment the stock
            $new_stock = $stock + 1;
            $update_book_query = "UPDATE books SET stock = ? WHERE book_id = ?";
            $stmt_update = mysqli_prepare($connection, $update_book_query);
            mysqli_stmt_bind_param($stmt_update, "ii", $new_stock, $book_id);
            mysqli_stmt_execute($stmt_update);
            mysqli_stmt_close($stmt_update);
        }

        // Step 4: Delete issued book record
        $delete_query = "DELETE FROM issued_books WHERE s_no = ?";
        $stmt_delete = mysqli_prepare($connection, $delete_query);
        mysqli_stmt_bind_param($stmt_delete, "i", $s_no);
        mysqli_stmt_execute($stmt_delete);
        mysqli_stmt_close($stmt_delete);

        // echo "Book Book Return successfully.";
        echo " <script>alert('Book Return successfully.');</script>";
    } else {
        // echo "Error: Book issue record not found.";
        // echo " <script>alert('Book issue record not found.');</script>";
    }
}

// (update renewal date)
if (isset($_GET['renew'])) {
    $s_no = $_GET['renew'];
    $renewal_date = date('Y-m-d', strtotime('+15 days'));
    $renew_query = "UPDATE issued_books SET renewal_date = '$renewal_date' WHERE s_no = '$s_no'";
    mysqli_query($connection, $renew_query);
}

                            
mysqli_close($connection);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard</title>
	<meta charset="utf-8" name="viewport" content="width=device-width,intial-scale=1">
	<link rel="stylesheet" type="text/css" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/admin_del.css">
    <link rel="stylesheet" href="../css/admin_manage.css">

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
    <h2 style="text-align: center; padding:20px ">Admin - Search User</h2>

    <!-- Search User Form -->
    <form method="post" action="">
        <div class="form-group">
            <label for="search_by">Search By:</label>
            <select name="search_by" id="search_by" required>
                <option value="id">User ID</option>
                <option value="name">User Name</option>
            </select>
        </div>

        <div class="form-group">
            <label for="search_value">Enter User ID or Name:</label>
            <input type="text" name="search_value"  required>
        </div>

        <button type="submit" name="search_user" class="renew">Search User</button>
    </form>

    <?php if ($user_details): ?>
    <div class="profile-container">
    <h2>User Details</h2>
    <p><strong>Name:</strong> <?php echo $user_details['name']; ?></p>
    <p><strong>Email:</strong> <?php echo $user_details['email']; ?></p>
    <p><strong>Mobile:</strong> <?php echo $user_details['mobile']; ?></p>
    <p><strong>Address:</strong> <?php echo $user_details['address']; ?></p>
    </div>
    <!-- Issued Books -->
    <h2 style="text-align: center;">Issued Books</h2>
    <table>
        <thead>
            <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Issue Date</th>
                <th>Renewal Date</th>
                <th>Fine</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($issued_books as $book): ?>
            <?php
                $fine = calculateFine($book['issue_date'], $book['renewal_date']);
                // $total_fine = $user_details['fine'] + $fine;
            ?>
            <tr>
                 <!--------to print book name ------------------ -->
                         <?php
                            $connection = mysqli_connect("localhost", "root", "", "pustakalayaa");
                            $query = "SELECT book_name FROM books WHERE book_id = '$book[book_id]'";
                            $query_run = mysqli_query($connection, $query);
                            while($row = mysqli_fetch_assoc($query_run)) {?>
                            <td><?php echo $row['book_name']; 
                        ?></td>
                        <?php }?>
                <td><?php echo $book['book_author']; ?></td>
                <td><?php echo $book['issue_date']; ?></td>
                <td><?php echo $book['renewal_date'] ?: 'Not Renewed'; ?></td>
                <td><?php echo $fine; ?> Rupees</td>
                <td>
                    <!-- Renew Book -->
                    <a href="?renew=<?php echo $book['s_no']; ?>" class="renew">Renew</a>
                    <!-- Delete Book -->
                    <a href="?delete=<?php echo $book['s_no']; ?>" class="delet">Return</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

</body>
</html>

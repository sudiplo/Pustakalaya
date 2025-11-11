<?php
include 'connect.php';  
session_start();


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
    // echo "<p>Invalid request. No book selected for renewal.</p>";
    echo " <script>alert('Invalid request. No book selected for renewal.');</script>";
}

$conn->close(); 
?>

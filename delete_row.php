<?php
// connect.php - Include your database connection code here if not already included

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['regno'])) {
    $regno = $_POST['regno'];

    // Establish database connection
    require("./connect.php");

    // Prepare a DELETE statement
    $sql = "DELETE FROM students WHERE regno = ?";
    $stmt = $connect->prepare($sql);

    if (!$stmt) {
        die("Error in SQL query: " . $connect->error);
    }

    // Bind the parameter and execute the statement
    $stmt->bind_param("s", $regno);
    if ($stmt->execute()) {
        echo "Row deleted successfully.";
    } else {
        echo "Error deleting row: " . $stmt->error;
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $connect->close();
} else {
    echo "Invalid request.";
}
?>

<?php
$conn = new mysqli("localhost", "root", "", "library_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = $_POST['id'];
$title = $_POST['title'];
$author = $_POST['author'];
$updateFields = [];
if (!empty($title)) {
    $updateFields[] = "title='$title'";
}
if (!empty($author)) {
    $updateFields[] = "author='$author'";
}
if (!empty($updateFields)) {
    $sql = "UPDATE books SET " . implode(", ", $updateFields) . " WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "No fields to update";
}
$conn->close();
header("Location: index.php");
?>
<?php
$conn = new mysqli("localhost", "root", "", "library_management");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_POST['action'];
$title = mysqli_real_escape_string($conn, $_POST['title']);
$author = mysqli_real_escape_string($conn, $_POST['author']);

if ($action == 'add') {
    $sql = "INSERT INTO books (title, author) VALUES ('$title', '$author')";
} elseif ($action == 'remove') {
    $sql = "DELETE FROM books WHERE title='$title' AND author='$author'";
} elseif ($action == 'update') {
    $newTitle = mysqli_real_escape_string($conn, $_POST['new_title']);
    $newAuthor = mysqli_real_escape_string($conn, $_POST['new_author']);
    $sql = "UPDATE books SET title='$newTitle', author='$newAuthor' WHERE title='$title' AND author='$author'";
}

if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
header("Location: index.php");
?>

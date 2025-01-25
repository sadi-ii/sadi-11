<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $studentname = $_POST['studentname'];
    $studentid = $_POST['studentid'];
    $email = $_POST['email']; 
    $bt = $_POST['booktitle'];
    $bd = $_POST['borrowdate'];
    $rn = $_POST['returndate'];
    $tn = $_POST['token'];
    $fees = $_POST['fees'];
    
    $errors = [];
    $borrowDate = strtotime($bd);
    $returnDate = strtotime($rn);
    if (empty($studentname) || !preg_match('/^[a-zA-Z\s]+$/', $studentname)) {
        $errors[] = 'Student Name is invalid';
    }
    if (empty($studentid) || !preg_match('/^\d{2}-\d{5}-\d{1}$/', $studentid)) {
        $errors[] = 'Invalid Student ID format';
    }
    if (empty($email) || !preg_match('/^\d{2}-\d{5}-\d@student\.aiub\.edu$/', $email)) {
        $errors[] = 'Invalid email format';
    }
    if (!$borrowDate || !$returnDate || $returnDate <= $borrowDate) {
        $errors[] = 'Invalid Borrow/Return Dates';
    }
    $dateDiff = ($returnDate - $borrowDate) / 86400;
    if ($dateDiff > 10 || $dateDiff <= 0) {
        $errors[] = 'Borrow period must be between 1 and 10 days';
    }
    if (!ctype_digit($tn)) {
        $errors[] = 'Token Number must contain only numbers';
    }
    if (!is_numeric($fees) || $fees <= 0) {
        $errors[] = 'Fees must be a positive number';
    }
    if (isset($_COOKIE["borrowed_books"])) {
        $borrowedBooks = json_decode($_COOKIE["borrowed_books"], true);
        if (in_array($bt, $borrowedBooks)) {
            $errors[] = "You can't borrow '$bt' as it's already taken by you.";
        }
    } else {
        $borrowedBooks = [];
    }
    if ($errors) {
        foreach ($errors as $error) {
            echo '<b style="color: red;">Error: ' . $error . '</b>';
        }
    } else {
        $borrowedBooks[] = $bt;
        setcookie("borrowed_books", json_encode($borrowedBooks), time() + 86400, "/");
        
        echo "<b><p style='text-align: center; font-size: 2rem;'>Invoice</p></b>";
        echo "<table style='width: 50%; border-collapse: collapse; margin: auto; background-color: #f9f9f9; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);'>";
        echo "<tr style='background-color: #8c8c8c; color: white; text-align: center;'>
                <th style='border: 1px solid #ddd; padding: 12px;'>Item</th>
                <th style='border: 1px solid #ddd; padding: 12px;'>Details</th>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f1f1f1;'>Student Name</td>
                <td style='padding: 12px; background-color: #f1f1f1;'>$studentname</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;'>Student ID</td>
                <td style='padding: 12px; background-color: #f9f9f9;'>$studentid</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f1f1f1;'>Email</td>
                <td style='padding: 12px; background-color: #f1f1f1;'>$email</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;'>Book Title</td>
                <td style='padding: 12px; background-color: #f9f9f9;'>$bt</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f1f1f1;'>Borrow Date</td>
                <td style='padding: 12px; background-color: #f1f1f1;'>$bd</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;'>Return Date</td>
                <td style='padding: 12px; background-color: #f9f9f9;'>$rn</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f1f1f1;'>Token Number</td>
                <td style='padding: 12px; background-color: #f1f1f1;'>$tn</td>
            </tr>";
        echo "<tr>
                <td style='border-right: 1px solid #ddd; padding: 12px; background-color: #f9f9f9;'>Fees</td>
                <td style='padding: 12px; background-color: #f9f9f9;'>$fees</td>
            </tr>";
        echo "</table><br>";
        echo '<div style="text-align: center; margin-top: 30px;">
                <button style="background-color: #d67373; color: white; border: none; padding: 12px 24px; margin: 10px; cursor: pointer; font-size: 1rem;" onclick="window.location.href=\'index.php\'">Back</button>
            </div>';
    }
} else {
    echo '<b>Error: Invalid request method</b>';
}
?>
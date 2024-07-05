<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: pages/login.php');
}

if ($_SESSION['role'] == "student") {
    header('location: pages/login.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //echo $_POST['user_to_find'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "techcommprototype";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    $sql = "SELECT * FROM users WHERE student_number = '$_POST[user_to_find]'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo $user['email'];
    } else {
        echo "User does not exist.";
    }
    
    $conn->close();


}


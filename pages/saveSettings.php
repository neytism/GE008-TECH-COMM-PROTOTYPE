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
        
    $values = $_POST['values'];
    $use_template = $_POST['use_template'];
    $values = mysqli_real_escape_string($conn, $values);
    $use_template = mysqli_real_escape_string($conn, $use_template);

    $sql = "SELECT val FROM settings WHERE id = '$_SESSION[user_id]'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    
        $sql = "UPDATE settings SET val = '$values' WHERE id = '$_SESSION[user_id]'";
    } else{
        $sql = "INSERT INTO settings (id, type, val) VALUES('$_SESSION[user_id]', 'individual', '$values')";
    }
    
    mysqli_query($conn, $sql);
    
    $sql = "UPDATE users SET use_template = '$use_template' WHERE id = '$_SESSION[user_id]'";
    mysqli_query($conn, $sql);

    echo "success";

    
    return;
}

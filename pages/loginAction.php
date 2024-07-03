<?php
session_start();

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

$uname = $_POST['uname'];
$pword = $_POST['pword'];
$_SESSION['success'] = "";

if(empty($uname)){ 
    echo "Username Required";
    return;
}

$sql = "SELECT u.id, u.username, u.password, u.name, u.role, o.name AS organization_name FROM users AS u JOIN organizations AS o ON u.organization = o.id WHERE u.username = '$uname'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if ($row["password"] == $pword)
        {
          $_SESSION['user_id'] = $row["id"];
          $_SESSION['role'] = $row["role"];
          $_SESSION['organization'] = $row["organization_name"];
          $sql = "INSERT INTO logs (type, userID, details) VALUES('user', '$row[id]', 'User $row[id] - $row[name] logged in.')";
          mysqli_query($conn, $sql);
            echo "success";
        }else {
            echo "Incorrect password or username.";
        }
  }
} else {
  echo "Incorrect password or username.";
}

$conn->close();
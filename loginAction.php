<?php
require 'config.php';
require 'setOrganizationRole.php';

$uname = $_POST['uname'];
$pword = $_POST['pword'];
$_SESSION['success'] = "";

if(empty($uname)){ 
    echo "Username Required";
    return;
}

if(empty($pword)){ 
  echo "Password Required";
  return;
}

$sql = "SELECT id, username, name, password, student_number, active_organization, role FROM users WHERE student_number = '$uname' OR username = '$uname'";

$result = $conn->query($sql);


if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $storedPassword = $row["password"];
    list($hashedPassword, $salt) = explode("::", $storedPassword);
    
    if (password_verify($pword . $salt, $hashedPassword))
    {
      // Login successful
      $_SESSION['user_id'] = $row["id"];
      $_SESSION['role'] = $row["role"];
      
      $sql = "INSERT INTO logs (type, userID, details) VALUES('user', '$row[id]', 'User $row[id] - $row[name] logged in.')";
      mysqli_query($conn, $sql);
      SetRole($conn, $row["id"], $row["active_organization"]);
      echo "success";
    } else {
      echo "Incorrect password or number.";
    }
  }
} else {
  echo "Incorrect password or number.";
}

function hashPassword($password) {
  // Generate a random salt
  $salt = bin2hex(random_bytes(16));
  
  // Hash the password with the salt
  $hashedPassword = password_hash($password . $salt, PASSWORD_DEFAULT);
  
  return array(
    'hash' => $hashedPassword,
    'salt' => $salt
  );
}

$conn->close();
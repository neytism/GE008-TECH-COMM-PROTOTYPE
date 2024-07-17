<?php
include 'config.php';


$type = $_POST['type'];
$value = $_POST['value'];
$user_id = $_POST['user_id'];
$organization_id = $_POST['organization_id'];

$type = mysqli_real_escape_string($conn, $type);
$value = mysqli_real_escape_string($conn, $value);
$user_id = mysqli_real_escape_string($conn, $user_id);
$organization_id = mysqli_real_escape_string($conn, $organization_id);

if($type == 'role'){
    $sql = "UPDATE user_organizations SET role = '$value' WHERE user_id = '$user_id' AND organization_id = '$organization_id'";
} else{
    $sql = "UPDATE user_organizations SET status = '$value' WHERE user_id = '$user_id' AND organization_id = '$organization_id'";
}


mysqli_query($conn, $sql);

echo "success";

$conn->close();
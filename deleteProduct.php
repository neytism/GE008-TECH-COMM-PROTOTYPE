<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    require 'config.php';
    require 'getUserDetails.php';

    
    $itemID = $_POST['itemID'];
    $item_name = $_POST['item_name'];
    
    $sql = "DELETE FROM items WHERE id = '$itemID'";
    
    mysqli_query($conn, $sql);

    $sql = "INSERT INTO logs (type, userID, details) VALUES('inventory', '$_SESSION[user_id]', 'User $_SESSION[user_id] - $name removed item: $itemID - $item_name')";
    mysqli_query($conn, $sql);
    
    echo 'success';
    
    $conn->close();


}


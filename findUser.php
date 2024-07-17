<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'config.php';

    $user_to_find = str_replace('-','', $_POST['user_to_find']); // this will cause error if email has '-'
    
    
    $sql = "SELECT * FROM users WHERE student_number = '$user_to_find' OR email = '$user_to_find'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo $user['email'];
    } else {
        if(!filter_var( $user_to_find, FILTER_VALIDATE_EMAIL)){
            echo "Invalid Input.";
        } else{
            echo "Customer not in Database.";
        }
        
    }
    
    $conn->close();


}


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require 'config.php';
    require 'setOrganizationRole.php';
    require 'getUserDetails.php';
    
    $new_name = $_POST['name'];
    $values_personal = $_POST['values_personal'];
    $values_organization = $_POST['values_organization'];
    $use_template = $_POST['use_template'];
    $new_active_organization = $_POST['active_organization'];
    
    $new_name = mysqli_real_escape_string($conn, $new_name);
    $values_personal = mysqli_real_escape_string($conn, $values_personal);
    $values_organization = mysqli_real_escape_string($conn, $values_organization);
    $use_template = mysqli_real_escape_string($conn, $use_template);
    $new_active_organization = mysqli_real_escape_string($conn, $new_active_organization);
    

    if( !empty($new_name) && $new_name != $name){

        $sql = "INSERT INTO logs (type, userID, details) VALUES('user', '$_SESSION[user_id]', 'User $_SESSION[user_id] - Changed name from $name into $new_name')";
        mysqli_query($conn, $sql);

        $sql = "UPDATE users SET name = '$new_name' WHERE id = '$_SESSION[user_id]'";
        mysqli_query($conn, $sql);
        
    }

    if(!empty($values_personal)){
        
        $sql = "SELECT val FROM settings WHERE id = '$_SESSION[user_id]'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
        
            $sql = "UPDATE settings SET val = '$values_personal' WHERE id = '$_SESSION[user_id]'";
        } else{
            $sql = "INSERT INTO settings (id, type, val) VALUES('$_SESSION[user_id]', 'individual', '$values_personal')";
        }
        
        mysqli_query($conn, $sql);
    }

    if(!empty($values_organization)){
        
        $sql = "UPDATE settings SET val = '$values_organization' WHERE id = '0' AND organization_id = '$organization_id'";
        
        mysqli_query($conn, $sql);
    }
    
    $sql = "UPDATE users SET use_template = '$use_template', active_organization = '$new_active_organization' WHERE id = '$_SESSION[user_id]'";
    
    mysqli_query($conn, $sql);
    
    SetRole($conn, $_SESSION['user_id'], $new_active_organization);
    echo "success";

    
    return;
}

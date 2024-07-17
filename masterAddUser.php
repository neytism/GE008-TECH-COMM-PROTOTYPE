<?php
include 'config.php';

$errors = array(
    'studentNumber' => '',
    'name' => '',
    'email' => ''
);


$master_student_number = $_POST['master_student_number'];
$master_name = $_POST['master_name'];
$master_email = $_POST['master_email'];

$master_student_number = strtolower($master_student_number);
$master_student_number = preg_replace("/[^a-zA-Z0-9]+/", "", $master_student_number);

if (empty($master_student_number)) {
    $errors['studentNumber'] = '-Student number is required.';
} else {
    $sql = "SELECT * FROM users WHERE student_number = '$master_student_number'";

    $result = $conn->query($sql);

    if (strlen($master_student_number) != 8) {
        $errors['studentNumber'] = '-Must be 8 digits.';
    } elseif (HasSpecialCharacters($master_student_number)) {
        $errors['studentNumber'] = '-Invalid student Number.';
    } elseif (strlen($master_student_number) < 8 && HasSpecialCharacters($master_student_number)) {
        $errors['studentNumber'] = '-Invalid student Number.';
    } elseif ($result->num_rows > 0) {
        $errors['studentNumber'] = '-student Number is Taken.';
    }
}

$master_name = ucfirst($master_name);
if (empty($master_name)) {
    $errors['name'] = '-Name is required';
} else {
    if (strlen($master_name) > 200) {
        $errors['name'] = '-Invalid, too long.';
    }
}

if (empty($master_email)) {
    $errors['email'] = '-Email is required';
} else {
    if (!filter_var($master_email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = '-Invalid email';
    } else{
        
        $sql = "SELECT * FROM users WHERE email = '$master_email'";

        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $errors['email'] = '-email is Taken.';
        }

    }
}

if (array_filter($errors)) {
    echo implode("<br>", array_filter($errors));
} else {
    
    $master_student_number = mysqli_real_escape_string($conn, $master_student_number);
    $master_name = mysqli_real_escape_string($conn, $master_name);
    $master_email = mysqli_real_escape_string($conn, $master_email);
    
    $sql = "INSERT INTO users(username, name, role, active_organization, password, email, student_number, use_template, use_username) 
            VALUES('$master_student_number','$master_name','student','1','$master_student_number', '$master_email', '$master_student_number', 'false', 'false')";
    
    mysqli_query($conn, $sql);

    $new_id = mysqli_insert_id($conn);

    $sql = "SELECT * FROM user_organizations WHERE user_id = '$new_id' AND organization_id = '1'";

    $result = $conn->query($sql);

    if (!$result->num_rows > 0) {

        $sql = "INSERT INTO user_organizations(user_id, organization_id) VALUES('$new_id','1')";
    
        mysqli_query($conn, $sql);
    }
    
    
    
    echo "success";

}



$conn->close();



function HasSpecialCharacters($str)
{
    return preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $str);
}
<?php
include 'config.php';

if (isset($_SESSION['user_id'])) {

    $joining = $_POST['join_org'];

    $sql = "SELECT * FROM user_organizations WHERE user_id = '$_SESSION[user_id]' AND organization_id = '$joining'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] == 'pending') {
            echo 'Already applied, wait for admins to approve.';
        } else {
            echo 'Already an approved seller.';
        }
        return;
    }

    $sql = "INSERT INTO user_organizations(user_id, organization_id, status, role) VALUES('$_SESSION[user_id]','$joining', 'pending', 'seller')";

    mysqli_query($conn, $sql);

    echo "success";

} else {


    $errors = array(
        'studentNumber' => '',
        'password' => '',
        'organization' => ''
    );


    $student_number = $_POST['student_number'];
    $joining = $_POST['join_org'];
    $pword = $_POST['pword'];
    $rpword = $_POST['rpword'];

    $student_number = strtolower($student_number);
    $student_number = preg_replace("/[^a-zA-Z0-9]+/", "", $student_number);

    if (empty($student_number)) {
        $errors['studentNumber'] = '- Student number is required.';
    } else {
        $sql = "SELECT * FROM users WHERE student_number = '$student_number'";

        $result = $conn->query($sql);

        if (strlen($student_number) != 8) {
            $errors['studentNumber'] = '- Must be 8 digits.';
        } elseif (HasSpecialCharacters($student_number)) {
            $errors['studentNumber'] = '- Invalid student Number.';
        } elseif (strlen($student_number) < 8 && HasSpecialCharacters($student_number)) {
            $errors['studentNumber'] = '- Invalid student Number.';
        } elseif ($result->num_rows < 0) {
            $errors['studentNumber'] = '- Student Number does not exist.';
        } elseif ($result->num_rows > 0) {

            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {

                $id_to_regiser = $row["id"];
            }

            if ($joining == '1') {

                $sql = "SELECT * FROM user_organizations WHERE user_id = '$id_to_regiser' AND organization_id = '$joining'";

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    if ($row['role'] != 'student') {
                        if ($row['status'] == 'approved') {
                            echo 'Already an approved individual seller.';
                            return;
                        } else{
                            echo 'Already Applied as Individual Seller. Wait for the admin\'s approval.';
                            return;
                        }
                    }


                }
            }

        } else {

            $sql = "SELECT * FROM user_organizations WHERE user_id = '$id_to_regiser' AND organization_id = '$joining' AND organization_id != '1'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['status'] == 'pending') {
                    echo 'Already applied, wait for admins to approve.';
                } else {
                    echo 'Already an approved seller.';
                }
                return;
            }
        }


    }

    if (empty($pword)) {
        $errors['password'] = '- Password is required.';
    } else {
        if (strlen($pword) < 8) {
            $errors['password'] = '- Password must be atleast 8 characters.';
        }
    }
    
    if (!empty($pword) && $rpword != $pword) {
        $errors['repeatPassword'] = '- Password did not match';
    }
    
    
    if (array_filter($errors)) {
        echo implode("\n", array_filter($errors));
    } else {
    
        $student_number = mysqli_real_escape_string($conn, $student_number);
        $joining = mysqli_real_escape_string($conn, $joining);
        $pword = mysqli_real_escape_string($conn, $pword);

        $hashedPassword = hashPassword($pword);
        $pword = $hashedPassword['hash'] . "::" . $hashedPassword['salt'];
            
        $sql = "UPDATE users SET password = '$pword', active_organization = '$joining', role = 'seller' WHERE student_number = '$student_number'";
    
        mysqli_query($conn, $sql);
    
        $sql = "SELECT * FROM users WHERE student_number = '$student_number'";
    
        $result = $conn->query($sql);
    
        while ($row = $result->fetch_assoc()) {
    
            $id_to_regiser = $row["id"];
        }
    
        if ($joining == '1') {
            $sql = "UPDATE user_organizations SET role = 'seller', status = 'pending' WHERE user_id = '$id_to_regiser' AND organization_id = '$joining'";
        } else {
            $sql = "INSERT INTO user_organizations(user_id, organization_id) VALUES('$id_to_regiser ','$joining')";
        }
    
    
    
        mysqli_query($conn, $sql);
    
        echo "success";
    
    }
    
}




function HasSpecialCharacters($str)
{
    return preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $str);
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
  
  //for reference
function generateHashedPassword($string){
    $hashedPassword = hashPassword($string);
    $password = $hashedPassword['hash'] . "::" . $hashedPassword['salt'];

    return $password;
}


$conn->close();
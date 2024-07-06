<?php

use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;

use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';

require 'PHPMailer/src/PHPMailer.php';

require 'PHPMailer/src/SMTP.php';

define('MAILHOST', "smtp.gmail.com");

define('USERNAME', "cfrrs.system@gmail.com");

define('PASSWORD', "xcgc qnba pbgr hway");

define('SEND_FROM', "cfrrs.system@gmail.com");

define('SEND_FROM_NAME', "CIIT RSO POS Prototype");

define('REPLY_TO', "cfrrs.system@gmail.com");

define('REPLY_TO_NAME', "Admin");


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
    
    $buyer_email = $_POST['email'];//
    $buyer_student_id = $_POST['student_id'];//
    $total_amount = $_POST['total_amount'];//
    $payment_method = $_POST['payment_method'];//
    $items = json_decode($_POST['items'], true);//

    date_default_timezone_set('Asia/Manila');
    $timestamp = time(); 
    $formattedTimestamp = date("m/d/Y H:i:s", $timestamp);//
    
    $sql = "SELECT * FROM users WHERE student_number = '$buyer_student_id'";
    
    $result = $conn->query($sql);
    
    while ($row = $result->fetch_assoc()) {
    
    $buyer_name = $row["name"]; //
    $buyer_id = $row["id"];
    }
    

    $sql = "SELECT u.id, u.username, u.password, u.name, u.role, u.organization, o.code, o.name AS organization_name FROM users AS u JOIN organizations AS o ON u.organization = o.id WHERE u.id = '$_SESSION[user_id]'";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        
        $seller_id = $row["id"];
        $seller_name = $row["name"];
        $organization_id = $row["organization"];
        $organization_name = $row["organization_name"];
        $organization_code = $row["code"];
    }

    $sql = "SELECT id FROM receipts WHERE id LIKE '$organization_code%' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['id'];
        $last_number = intval(substr($last_id, strlen($organization_code)));
        $itemCode = $organization_code . str_pad($last_number + 1, 6, '0', STR_PAD_LEFT);
    } else {
        $itemCode = $organization_code . '000001';
    }

    $formattedItemCode = formatString($itemCode);

    $details = "";

    foreach ($items as $item){
        $details =  $details . $item['quantity'] . " x " . $item['item_id'] . " - " . $item['name'] . " = " . $item['price'] . " . ";
    }
    
    
    $subject = "Receipt for " . $formattedItemCode ;

    $message = '';
    $message .= '<div style="background-color: #f2f2f2; padding: 20px;">';
    $message .= '    <div style="text-align: center; font-size: 1.8rem; font-family: Loew-ExtraBold !important; margin-bottom: 20px;">RECEIPT</div>';
    $message .= '    <div style="text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important; margin-bottom: 10px;">' . $formattedItemCode . '</div>';
    $message .= '    <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">';
    $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px;">' . $formattedTimestamp . '</div>';
    $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px;">' . $buyer_name . '</div>';
    $message .= '    <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">';
    $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px;">' . $organization_name . '</div>';
    $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px;">' . $seller_name . '</div>';
    $message .= '    <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px;">';
    $message .= '    <div style="text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important; margin-bottom: 10px; margin-top: 10px;">Items</div>';
    foreach ($items as $item) {
        $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px;">' . $item['quantity'] . ' - ' . $item['name'] . ' - ' . $item['price'] . '</div>';
    }
    $message .= '    <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px">';
    $message .= '    <div style="text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important; margin-bottom: 10px; margin-top: 10px;">TOTAL AMOUNT: ' . $total_amount . '</div>';
    $message .= '    <hr style="border-top: 2px dotted rgba(0, 0, 0, 1);">';
    $message .= '    <div style="text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important; margin-bottom: 10px; margin-top: 10px;">Thank you for your purchase!</div>';
    $message .= '</div>';
    
    $email_result = sendMail($buyer_email, $subject, $message);

    $receipt_display = '';
    
    $receipt_display .= '<div style="position:fixed; background-color: rgba(0,0,0,0.7); height: 100vh; width: 100vw; z-index: 100; cursor: pointer;" id="receipt-holder" onclick="CloseReceipt()">';
    $receipt_display .= '    <div class="login-panel shadow">';
    $receipt_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 1.8rem; font-family: Loew-ExtraBold !important;">RECEIPT</div>';
    $receipt_display .= '        <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">'.$formattedItemCode.'</div>';
    $receipt_display .= '        <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">';
    $receipt_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$formattedTimestamp.'</div>';
    $receipt_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$buyer_name.'</div>';
    $receipt_display .= '        <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">';
    $receipt_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">Organization: '.$organization_name.'</div>';
    $receipt_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$seller_name.'</div>';
    $receipt_display .= '        <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px;">';
    $receipt_display .= '        <div style="margin-bottom: 10px; margin-top: 10px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">Items</div>';
    foreach ($items as $item){
    $receipt_display .= '        <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$item['quantity'].' - '.$item['name'].' - '.$item['price'].'</div>';
    }
    $receipt_display .= '        <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px">';
    $receipt_display .= '        <div style="margin-bottom: 10px; margin-top: 10px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">TOTAL AMOUNT: '.$total_amount.'</div>';
    $receipt_display .= '        <hr style="border-top: 2px dotted rgba(0, 0, 0, 1);">';
    $receipt_display .= '        <div style="margin-bottom: 5px; margin-top: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$email_result.'</div>';
    $receipt_display .= '    </div>';
    $receipt_display .= '</div>';

    $error_display = '';

    $error_display .= '<div style="position:fixed; background-color: rgba(0,0,0,0.7); height: 100vh; width: 100vw; z-index: 100; cursor: pointer;" id="receipt-holder" onclick="CloseReceipt()">';
    $error_display .= '    <div class="login-panel shadow">';
    $error_display .= '        <div style="margin-bottom: 5px; text-align: center; font-size: 1.8rem; font-family: Loew-ExtraBold !important;">ERROR</div>';
    $error_display .= '        <div style="margin-bottom: 5px; margin-top: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">'.$email_result.'</div>';
    $error_display .= '    </div>';
    $error_display .= '</div>';

    
    if($email_result == "Email not sent."){
        echo $error_display;
    } else{
        echo $receipt_display;
        $sql = "INSERT INTO receipts(id, buyer_id, seller_id, organization_id, details, total_amount, payment_method) VALUES ('$itemCode','$buyer_id','$seller_id','$organization_id', '$details', '$total_amount','$payment_method') ";
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO logs(id, buyer_id, seller_id, organization_id, details, total_amount, payment_method) VALUES ('$itemCode','$buyer_id','$seller_id','$organization_id', '$details', '$total_amount','$payment_method') ";
        mysqli_query($conn, $sql);
    }
    
    // // $sql = "SELECT * FROM users WHERE student_number = '$_POST[user_to_find]'";
    
    // // $result = $conn->query($sql);
    
    // // if ($result->num_rows > 0) {
    // //     $user = $result->fetch_assoc();
    // //     echo $user['email'];
    // // } else {
    // //     echo "User does not exist.";
    // // }
    
    $conn->close();

}

function formatString($input) {
    $formattedString = '';
    $length = strlen($input);
    
    for ($i = 0; $i < $length; $i += 3) {
        $formattedString .= substr($input, $i, 3);
        
        if ($i + 3 < $length) {
            $formattedString .= '-';
        }
    }
    
    return $formattedString;
}


function sendMail($email, $subject, $message){

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->SMTPAuth = true;

    $mail->Host = MAILHOST;

    $mail->Username = USERNAME;

    $mail->Password = PASSWORD;
    
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->Port = 587;

    $mail->setFrom(SEND_FROM, SEND_FROM_NAME);

    $mail->addAddress($email);

    $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);

    $mail->isHTML(true);

    $mail->Subject = $subject;

    $mail->Body = $message;

    $mail->AltBody = $message;
    
     if(!$mail->send()){
        
         return "Email not sent.";
        }else{
        
        return "sent via email. click anywhere to close.";
     }
}
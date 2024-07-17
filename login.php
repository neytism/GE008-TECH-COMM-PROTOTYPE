<?php 
	session_start(); 

	if (isset($_SESSION['user_id'])) {
		header('location: index.php');
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/ciit.png">
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Login</title>
</head>
<body>
    
    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    
    <div class="main-interface">
        
        <form id="loginForm">

            <div class="login-panel shadow">
                <div style="margin-bottom: 10px; margin-top: 10px; text-align: center; font-size: 1.5rem; font-family: Loew-ExtraBold !important;">LOGIN</div>
                <input style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;" type="text" id="inputUserName" placeholder="Student Number" required>
                
                <input style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"type="password" id="inputPassword" placeholder="Password" required>
                <button type="submit" style="margin: 15px 25px; border-radius: 1rem; border: none;" class="confirm-button confirm" onclick="checkLogin(event)">CONFIRM</button>
                <a style="color:var(--cancel-color); text-align: center;" href="register.php">Not a registered seller.</a>
                <div style="margin: 15px 25px; border-radius: 1rem; background-color: rgba(0, 0, 0, 0.466); display: none;" class="confirm-button confirm" id="warningTextLogIn">
                    
                </div>
        
            </div>
        
        </form>
        
        <div style=" text-align: right; padding:10px; position: fixed; bottom: 0; right: 0; font-size: 12px; white-space: nowrap; color: #00000036;">Chiuco O., Florendo N., Reyes Z., Reyes M., Santaigo P.<br>Technical Communication Group 29</div>
       
    </div>
    
   
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/login.js" id="rendered-js"></script>

    
</body>
</html>
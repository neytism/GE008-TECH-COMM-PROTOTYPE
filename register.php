<?php 
	require 'config.php';

    $sql = "SELECT * FROM organizations";

    $result = mysqli_query($conn, $sql);

    $organizations_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/ciit.png">
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Register</title>
</head>
<script>
    function joinCheck(){
        
        var joinOrg = document.getElementById("inputJoin").value;
        var studentNumber = document.getElementById("inputStudentNumber").value;
        var password = document.getElementById("inputPassword").value;
        var repeatPassword = document.getElementById("inputRepeatPassword").value;
        
        let formData = new FormData();
        
        formData.append('join_org', joinOrg);
        formData.append('student_number', studentNumber);
        formData.append('pword', password);
        formData.append('rpword', repeatPassword);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'registerAction.php', true);
        xhr.onload = function() {
            if(this.responseText.trim() == "success"){
                alert('Success! Just wait for the confirmation from the organization Admins.');
                window.location.href='login.php'
            } else{
                alert(this.responseText);
            }
        };
        
        xhr.send(formData);
    }
</script>
<body>
    
    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    
    <div class="main-interface">
        
        <form id="loginForm">

            <div class="login-panel shadow">
                <div style="margin-bottom: 10px; margin-top: 10px; text-align: center; font-size: 1.5rem; font-family: Loew-ExtraBold !important;">REGISTER AS SELLER</div>
                <input style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;" type="text" id="inputStudentNumber" placeholder="Student Number" required>
                <select class="category-dropdown" style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px; cursor: pointer;"
                    name="organization" id="inputJoin" title="Select Organization">
                    <?php
                        foreach ($organizations_list as $orgs) {?>
                            <option value="<?php echo htmlspecialchars($orgs['id']); ?>"><?php echo htmlspecialchars($orgs['organization_name']); ?></option>
                        <?php }
                    ?>
                </select>
                <input style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;" type="password" id="inputPassword" placeholder="Password" required>
                <input style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;" type="password" id="inputRepeatPassword" placeholder="Repeat Password" required>
                <button type="button" style="margin: 15px 25px; border-radius: 1rem; border: none;" class="confirm-button confirm" onclick="joinCheck()">REGISTER</button>
                <a style="color:var(--cancel-color); text-align: center;" href="login.php">Already a registered seller.</a>
                <div style="margin: 15px 25px; border-radius: 1rem; background-color: rgba(0, 0, 0, 0.466); display: none;" class="confirm-button confirm" id="warningTextLogIn">
                    
                </div>
        
            </div>
        
        </form>
        
        <div style=" text-align: right; padding:10px; position: fixed; bottom: 0; right: 0; font-size: 12px; white-space: nowrap; color: #00000036;">Chiuco O., Florendo N., Reyes Z., Reyes M., Santaigo P.<br>Technical Communication Group 29</div>
       
    </div>
    
   
    
    <scripts src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></scripts>
    <script type="text/javascript" src="js/login.js" id="rendered-js"></script>

    
</body>
</html>
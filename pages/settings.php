<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: pages/login.php');
}

if ($_SESSION['role'] == "student") {
    header('location: pages/login.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
}

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

$sql = "SELECT u.username, u.name, u.organization, u.use_template, o.code, o.name AS organization_name FROM users AS u JOIN organizations AS o ON u.organization = o.id WHERE u.id = '$_SESSION[user_id]'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    
    $name = $row["name"];
    $organization_name = $row["organization_name"];
    $organization_id = $row["organization"];
    $organization_code = $row["code"];
    $use_template = $row["use_template"];
}

if (isset($_SESSION['user_id'])) {
    $sql = "SELECT val FROM settings WHERE id = '$_SESSION[user_id]'";
} else{
    $sql = "SELECT val FROM settings WHERE id = '-1'";
}

$result = $conn->query($sql);
    
if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $values = explode('|', $row['val']);
    
    $settings = array();
    foreach ($values as $pair) {
        list($key, $value) = explode(':', $pair, 2);
        $settings[trim($key)] = str_ireplace(';',"",trim($value));
    }
} else{
    
    $sql = "SELECT val FROM settings WHERE id = '-1'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $values = explode('|', $row['val']);
    
    $settings = array();
    foreach ($values as $pair) {
        list($key, $value) = explode(':', $pair, 2);
        $settings[trim($key)] = str_ireplace(';',"",trim($value));

    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/qiqi.png">
    <link rel="stylesheet" type="text/css" href="../css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css">
    <title>Inventory</title>
</head>
<body>
    
    <button class="test-button" onclick="printColors()"> TEST </button>

    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    <nav class="navbar">
        <!-- LOGO -->
    
        <div class="nav-left">
            <div class="menu">
            <a href="#"
                    class="logo"><?php if ($organization_name == "Individual") {
                        if($_SESSION['role'] == "master"){
                            echo htmlspecialchars("MASTER");
                        } else{
                            echo htmlspecialchars(strtoupper($name));
                        }
                        
                    } else {
                        if($_SESSION['role'] == "admin"){
                            echo htmlspecialchars("ADMIN: " . strtoupper($organization_code));
                        } else{
                            echo htmlspecialchars(strtoupper($organization_name));
                        }
                        
                    } ?></a>
    
            </div>
        </div>
    
    
        <div class="nav-right">
    
            <!-- NAVIGATION MENUS -->
            <div class="menu seller">
                <li><a><?php echo htmlspecialchars(strtoupper($name)); ?></a></li>
            </div>
        </div>
    
    </nav>
    
    <div class="mobile-nav shadow">
        <div class="left-nav-icon button" title="HOME" onclick="goToPage('../index.php'); homeButton();"><i class="bi bi-house"></i>HOME
        </div>
        <div class="left-nav-icon button cart-icon" title="CART" onclick="goToPage('../index.php?cart=1'); cartButton();"><i class="bi bi-cart"></i>CART
        </div>
        <div class="left-nav-icon button" title="INVENTORY" onclick="window.location.href='inventory.php'"><i
                class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" onclick="window.location.href='logs.php'"><i
                class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button" title="REPORTS" onclick="window.location.href='reports.php'"><i
                class="bi bi-bar-chart-line"></i>REPORTS</div>
        <?php 
        if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'master'){
        ?><div class="left-nav-icon button" title="USERS" onclick="window.location.href='users.php'"><i
                class="bi bi-person"></i>USERS</div><?php
        }
        ?>
        <div class="left-nav-icon button selected" title="SETTINGS" onclick="window.location.href='settings.php'"><i
                class="bi bi-gear"></i>SETTINGS</div>
            
        <div class="left-nav-icon button" title="LOGOUT" onclick="window.location.href='../index.php?logout=1'"><i
                class="bi bi-box-arrow-left"></i>LOGOUT</div>
    </div>
    
    <div class="main-interface with-navbar" >
    <div class="left-panel">
            <div class="left-panel-content shadow unselectable">
                <div class="left-nav-upper">
                    <div class="left-nav-icon button" onclick="window.location.href='../index.php'"><i class="bi bi-house"></i>HOME
                    </div>
                    <div class="left-nav-icon button cart-icon" onclick="window.location.href='../index.php'"><i class="bi bi-cart"></i>CART
                    </div>
                    <div class="left-nav-icon button" onclick="window.location.href='inventory.php'"><i
                            class="bi bi-boxes" ></i>INVENTORY</div>
                    <div class="left-nav-icon button" onclick="window.location.href='logs.php'"><i
                            class="bi bi-journal-text"></i>LOGS</div>
                    <div class="left-nav-icon button" onclick="window.location.href='reports.php'"><i
                            class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <?php 
                    if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'master'){
                    ?><div class="left-nav-icon button" onclick="window.location.href='users.php'"><i
                            class="bi bi-person"></i>USERS</div><?php
                    }
                    ?>
                    
                    <div class="left-nav-icon button selected" onclick="window.location.href='settings.php'"><i
                            class="bi bi-gear"></i>SETTINGS</div>
                </div>

                <div class="left-nav-lower">
                    <div class="left-nav-icon button" onclick="window.location.href='../index.php?logout=1'"><i
                            class="bi bi-box-arrow-left"></i>LOGOUT</div>
                </div>

            </div>
        </div>
        
        <div class="center-panel" style=" width: 100%;">
            <div class="center-panel-content" >
                
                
                
                <div class="settings-panel unselectable">
                    
                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">

                        <h1 class="text-outline">SETTINGS<br></h1>
                    
                        <form action="" style="margin: 25px 25px;">

                            <label class="text-outline">CUSTOMIZATION</label>
                            
                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                 <input type="checkbox" id="useTemplate" name="" value="" style="height: 25px; width: 25px;" <?php if($use_template == 'true'){ echo htmlspecialchars("checked");} ?> onclick="checkBoxClick()">
                                 <label for="useTemplate"><?php if ($organization_id == 1){echo htmlspecialchars('Use Default Template'); }else { echo htmlspecialchars('Use Organization Template ('. $organization_code . ')');} ?></label><br><br>
                            
                            </div>
                            
                            <!-- <div class="color-picker-container" style="margin: 25px 0px;">
                                 <input type="checkbox" id="useUsername" name="" value="" style="height: 25px; width: 25px;">
                                 <label for="useUsername">Use Username on navigation bar</label><br><br>
                            </div> -->
                            
                            <label class="text-outline">PERSONAL</label>
                            
                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--navbar-color-1']?>" variable="--navbar-color-1">
                                <label for="picker">Navigation Bar color 1</label>
                            </div>
                            
                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--navbar-color-2']?>" variable="--navbar-color-2">
                                <label for="picker">Navigation Bar color 2</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--navbar-text-color']?>" variable="--navbar-text-color">
                                <label for="picker">Navigation Bar Text Color</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--background-color-1']?>" variable="--background-color-1">
                                <label for="picker">Background color 1</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--background-color-2']?>" variable="--background-color-2">
                                <label for="picker">Background color 2</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--primary-color']?>" variable="--primary-color">
                                <label for="picker">Primary color</label>
                            </div>
                            
                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--button-accent-color']?>" variable="--button-accent-color">
                                <label for="picker">Button Accent color</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--card-color']?>" variable="--card-color">
                                <label for="picker">Card color</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--card-text-color']?>" variable="--card-text-color">
                                <label for="picker">Card text color</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--cancel-color']?>" variable="--cancel-color">
                                <label for="picker">Cancel color</label>
                            </div>

                            <div class="color-picker-container text-outline" style="margin: 25px 0px;">
                                <input id="picker" value="<?php echo $settings['--confirm-color']?>" variable="--confirm-color">
                                <label for="picker">Confirm color</label>
                            </div>
                            
                            <!-- <input type="checkbox" id="backgroundImage" name="" value="">
                            <label for="backgroundImage">Use Background Image</label><br><br>
                            <input type="checkbox" id="backgroundImage" name="" value="">
                            <label for="backgroundImage">Gradient Navigation Bar</label><br><br> -->
                            
                            <div style="display: flex; gap: 15px;" >
                                <div style="width: 50%;" class="confirm-button cancel" onclick="cancelButton()">CANCEL</div>
                                <div style="width: 50%; border: none;" class="confirm-button confirm" onclick="saveButton()">SAVE</div>
                            </div>
                          </form>
                      
                    </div>
                    
                </div>
            
                <div class="settings-panel shadow unselectable hide" style="width: 100% !important;">
                    <div class="category-button">Aldddddddddddddddddsdfgdfgsl</div>
                </div>


            </div>
        </div>
    
        <div style=" text-align: right; padding:10px; position: fixed; bottom: 0; right: 0; font-size: 12px; white-space: nowrap; color: #00000036;">Chiuco O., Florendo N., Reyes Z., Reyes M., Santaigo P.<br>Technical Communication Group 29</div>

        
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/search.js" id="rendered-js"></script>
    <script type="text/javascript" src="../js/navigation.js" id="rendered-js"></script>
    <script type="text/javascript" src="../js/colorPicker.js" id="rendered-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>

    <script type="text/javascript" src="../js/settings.js" id="rendered-js"></script>

</body>
</html>
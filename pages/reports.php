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



$sql = "SELECT u.username, u.name, u.organization,o.code, o.name AS organization_name FROM users AS u JOIN organizations AS o ON u.organization = o.id WHERE u.id = '$_SESSION[user_id]'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    
    $name = $row["name"];
    $organization_name = $row["organization_name"];
    $organization_id = $row["organization"];
    $organization_code = $row["code"];
}


$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$dataPointsYear = array();
for ($i = 0; $i < 12; $i++) {
    $dataPointsYear[] = array("label" => $months[$i], "y" => rand(10, 50));
}

$dataPointsMonth = array(
    array("label" => "Week 1", "y" => 33),
    array("label" => "Week 2", "y" => 25),
    array("label" => "Week 3", "y" => 10),
    array("label" => "Week 4", "y" => 50)
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/qiqi.png">
    <link rel="stylesheet" type="text/css" href="../css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Inventory</title>
</head>
<script>
window.onload = function () {
 
var chartMonth = new CanvasJS.Chart("chartContainerMonth", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Sales for this Month"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPointsMonth, JSON_NUMERIC_CHECK); ?>
	}]
});


chartMonth.render();

var chartYear = new CanvasJS.Chart("chartContainerYear", {
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Sales for this Year"
	},
	axisY:{
		includeZero: true
	},
	data: [{
		type: "column", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPointsYear, JSON_NUMERIC_CHECK); ?>
	}]
});


chartYear.render();
 
}
</script>
<body>
    
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
        <div class="left-nav-icon button selected" title="REPORTS" onclick="window.location.href='reports.php'"><i
                class="bi bi-bar-chart-line"></i>REPORTS</div>
        <?php 
        if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'master'){
        ?><div class="left-nav-icon button" title="USERS" onclick="window.location.href='users.php'"><i
                class="bi bi-person"></i>USERS</div><?php
        }
        ?>
        <div class="left-nav-icon button" title="SETTINGS" onclick="window.location.href='settings.php'"><i
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
                    <div class="left-nav-icon button selected" onclick="window.location.href='reports.php'"><i
                            class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <?php 
                    if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'master'){
                    ?><div class="left-nav-icon button" onclick="window.location.href='users.php'"><i
                            class="bi bi-person"></i>USERS</div><?php
                    }
                    ?>
                    
                    <div class="left-nav-icon button" onclick="window.location.href='settings.php'"><i
                            class="bi bi-gear"></i>SETTINGS</div>
                </div>

                <div class="left-nav-lower">
                    <div class="left-nav-icon button" onclick="window.location.href='../index.php?logout=1'"><i
                            class="bi bi-box-arrow-left"></i>LOGOUT</div>
                </div>

            </div>
        </div>
        
        <div class="center-panel" style="margin-right: 15px; width: 100%;">
            <div class="center-panel-content" >
                
                
                
                <div class="products-panel unselectable">
                    
                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">
                        <div id="chartContainerMonth" style="height: 500px; width: 100%;"></div>
                    </div>

                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">
                        <div id="chartContainerYear" style="height: 500px; width: 100%;"></div>
                    </div>
                    
                </div>
            
                <div class="settings-panel shadow unselectable hide" style="width: 100% !important;">
                    <div class="category-button">Aldddddddddddddddddsdfgdfgsl</div>
                </div>


            </div>
        </div>

        
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="../js/search.js" id="rendered-js"></script>
    <script type="text/javascript" src="../js/navigation.js" id="rendered-js"></script>

    <script type="text/javascript" src="../js/settings.js" id="rendered-js"></script>
    
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    
</body>
</html>
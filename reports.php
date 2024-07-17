<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

if ($_SESSION['role'] == "student") {
    header('location: login.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
}

require 'getUserDetails.php';

$months = array("Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$dataPointsYear = array();
for ($i = 0; $i < 12; $i++) {
    $dataPointsYear[] = array("label" => $months[$i], "y" => rand(10, 50));
}

$dataPointsDaily = array();
for ($i = 5; $i < 20; $i++) {
    if($i == 19){
        $dataPointsDaily[] = array("label" => 'Today', "y" => rand(2, 15));
    } else{
        $dataPointsDaily[] = array("label" => 'July ' .$i, "y" => rand(2, 15));
    }
    
}

$dataPointsItems = array();
$totalY = 0;

// Generate random y values
for ($i = 0; $i < 6; $i++) {
    $y = mt_rand(1, 50);
    $dataPointsItems[] = array("label" => "Item " . ($i + 1), "y" => $y);
    $totalY += $y;
}

// Normalize the y values to add up to 100%
foreach ($dataPointsItems as &$item) {
    $item["y"] = ($item["y"] / $totalY) * 100;
}

$dataPointsMonth = array(
    array("label" => "Week 1", "y" => rand(10, 50)),
    array("label" => "Week 2", "y" => rand(10, 50)),
    array("label" => "Week 3", "y" => rand(10, 50)),
    array("label" => "Week 4", "y" => rand(10, 50))
);

if ($_SESSION['role'] == 'master'){
    $sql = "SELECT * FROM organizations";
    $result = mysqli_query($conn, $sql);
    $organizations = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
    <title>REPORTS</title>
</head>
<script>
window.onload = function () {
var bgcolor = getComputedStyle(document.body).getPropertyValue('--card-color');
var txtcolor = getComputedStyle(document.body).getPropertyValue('--card-text-color');
var accentcolor = getComputedStyle(document.body).getPropertyValue('--button-accent-color');
var gradient1 = getComputedStyle(document.body).getPropertyValue('--background-color-1');
var gradient2 = getComputedStyle(document.body).getPropertyValue('--navbar-color-1');

var chartDaily = new CanvasJS.Chart("chartContainerDaily", {
	animationEnabled: true,
	exportEnabled: true,
    backgroundColor: bgcolor,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Sales Daily",
        fontColor: txtcolor
	},
    axisX:{
		titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
	},
	axisY:{
		includeZero: true,
        titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
	},
	data: [{
		type: "line", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
        lineColor: txtcolor,
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: <?php echo json_encode($dataPointsDaily, JSON_NUMERIC_CHECK); ?>
	}]
});


chartDaily.render();

var chartItems = new CanvasJS.Chart("chartContainerItems", {
	animationEnabled: true,
    backgroundColor: bgcolor,
	title: {
		text: "Items sold overall",
        fontColor: txtcolor
	},
	subtitles: [{
		text: "2024",
        fontColor: txtcolor
	}],
	data: [{
		type: "pie",
        indexLabelFontColor: txtcolor,
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPointsItems, JSON_NUMERIC_CHECK); ?>
	}]
});
chartItems.render();
 
var chartMonth = new CanvasJS.Chart("chartContainerMonth", {
	animationEnabled: true,
    backgroundColor: bgcolor,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Sales for this Month",
        fontColor: txtcolor
	},
	axisX:{
		titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
	},
	axisY:{
		includeZero: true,
        titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
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
    backgroundColor: bgcolor,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Sales for this Year",
        fontColor: txtcolor
	},
	axisX:{
		titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
	},
	axisY:{
		includeZero: true,
        titleFontColor: txtcolor,
        labelFontColor: txtcolor,
        gridColor: accentcolor,
        lineColor: accentcolor
	},
	data: [{
		type: "area", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
        lineColor: txtcolor,
        color:accentcolor,
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
                    class="logo"><?php 
                    if($_SESSION['role'] == "master"){
                        echo htmlspecialchars("MASTER");
                    } else {
                        if ($organization_name == "Individual") {
                            echo htmlspecialchars(strtoupper($name));
                        } else{
                            if($_SESSION['org_role'] == "admin"){
                                echo htmlspecialchars("ADMIN: " . strtoupper($organization_code));
                            } else{
                                echo htmlspecialchars(strtoupper($organization_name));
                            }
                        }
                    }
                     ?></a>
    
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
        <div class="left-nav-icon button" title="HOME" onclick="goToPage('index.php'); homeButton();"><i class="bi bi-house"></i>HOME
        </div>
        <div class="left-nav-icon button cart-icon" title="CART" onclick="goToPage('index.php?cart=1'); cartButton();"><i class="bi bi-cart"></i>CART
        </div>
        <div class="left-nav-icon button" title="INVENTORY" onclick="window.location.href='inventory.php'"><i
                class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" onclick="window.location.href='logs.php'"><i
                class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button selected" title="REPORTS" onclick="window.location.href='reports.php'"><i
                class="bi bi-bar-chart-line"></i>REPORTS</div>
        <?php 
        if($_SESSION['org_role'] == 'admin' || $_SESSION['role'] == 'master'){
        ?><div class="left-nav-icon button" title="USERS" onclick="window.location.href='users.php'"><i
                class="bi bi-person"></i>USERS</div><?php
        }
        ?>
        <div class="left-nav-icon button" title="SETTINGS" onclick="window.location.href='settings.php'"><i
                class="bi bi-gear"></i>SETTINGS</div>
            
        <div class="left-nav-icon button" title="LOGOUT" onclick="window.location.href='index.php?logout=1'"><i
                class="bi bi-box-arrow-left"></i>LOGOUT</div>
    </div>
    
    <div class="main-interface with-navbar" >
    <div class="left-panel">
            <div class="left-panel-content shadow unselectable">
                <div class="left-nav-upper">
                    <div class="left-nav-icon button" onclick="window.location.href='index.php'"><i class="bi bi-house"></i>HOME
                    </div>
                    <div class="left-nav-icon button cart-icon" onclick="window.location.href='index.php'"><i class="bi bi-cart"></i>CART
                    </div>
                    <div class="left-nav-icon button" onclick="window.location.href='inventory.php'"><i
                            class="bi bi-boxes" ></i>INVENTORY</div>
                    <div class="left-nav-icon button" onclick="window.location.href='logs.php'"><i
                            class="bi bi-journal-text"></i>LOGS</div>
                    <div class="left-nav-icon button selected" onclick="window.location.href='reports.php'"><i
                            class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <?php 
                    if($_SESSION['org_role'] == 'admin' || $_SESSION['role'] == 'master'){
                    ?><div class="left-nav-icon button" onclick="window.location.href='users.php'"><i
                            class="bi bi-person"></i>USERS</div><?php
                    }
                    ?>
                    
                    <div class="left-nav-icon button" onclick="window.location.href='settings.php'"><i
                            class="bi bi-gear"></i>SETTINGS</div>
                </div>

                <div class="left-nav-lower">
                    <div class="left-nav-icon button" onclick="window.location.href='index.php?logout=1'"><i
                            class="bi bi-box-arrow-left"></i>LOGOUT</div>
                </div>

            </div>
        </div>
        
        <div class="center-panel" style="margin-right: 15px; width: 100%;">
            <div class="center-panel-content" >
                
                
                
                <div class="products-panel unselectable">
                    
                    <?php if($_SESSION['role'] == 'master'){ ?> 

                        <div class="color-picker-container text-outline">
                        <select class="category-dropdown" style="margin-right: 15px; background-color: var(--card-color);color: var(--card-text-color); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px; cursor: pointer;"
                        name="Active Organization" id="inputOrganization" title="Select Active Organization" onchange="location.reload()">
                        <?php foreach ($organizations as $org) { ?>
                                <option style="background-color: rgb(125, 125, 125); height: 100px;" value="<?php echo htmlspecialchars($org['id']); ?>" <?php if($org['id'] == $organization_id) echo htmlspecialchars("selected") ?>><?php echo htmlspecialchars($org['organization_name']); ?></option>
                            <?php } ?>
                        </select>
                            <label for="useTemplate" style="color: var(--card-color);">Select Organization</label><br><br>
                    
                    </div>
                        
                    <?php }?>
                    

                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">
                        <div id="chartContainerDaily" style="height: 500px; width: 100%;"></div>
                    </div>

                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">
                        <div id="chartContainerItems" style="height: 500px; width: 100%;"></div>
                    </div>
                    
                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">
                        <div id="chartContainerMonth" style="height: 500px; width: 100%;"></div>
                    </div>

                    <div style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; margin-bottom: 30px;">
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
    <script type="text/javascript" src="js/search.js" id="rendered-js"></script>
    <script type="text/javascript" src="js/navigation.js" id="rendered-js"></script>

    <script type="text/javascript" src="js/settings.js" id="rendered-js"></script>
    
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
    
</body>
</html>
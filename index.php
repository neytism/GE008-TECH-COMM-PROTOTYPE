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

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    header("location: pages/login.php");
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "techcommprototype";

$name = '';
$organization = '';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SELECT u.id, u.username, u.password, u.name, u.role, u.organization, o.name AS organization_name FROM users AS u JOIN organizations AS o ON u.organization = o.id WHERE u.id = '$_SESSION[user_id]'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    
    $name = $row["name"];
    $organization = $row["organization_name"];
    $organization_id = $row["organization"];
}

if ($organization_id == '1') {
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' AND user_id = '$_SESSION[user_id]'";
} else {
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id'";
}

$result = mysqli_query($conn, $sql);

$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM item_category";

$result = mysqli_query($conn, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/qiqi.png">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Prototype</title>
</head>

<body>
    
    <button class="test-button"> TEST </button>
    
    <div id="receipt-parent">
        <!-- <div style="position:fixed; background-color: rgba(0,0,0,0.7); height: 100vh; width: 100vw; z-index: 100; cursor: pointer;" id="receipt-holder" class="" onclick="CloseReceipt()">
            <div class="login-panel shadow">
                <div style="margin-bottom: 5px; text-align: center; font-size: 1.8rem; font-family: Loew-ExtraBold !important;">RECEIPT</div>  
                <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">IND-000-000</div>
                <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">  
                <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">00.00.0000, 00:00:00</div>  
                <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">Buyer Name</div>
                <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px; margin-bottom: 10px;">  
                <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">Organization Name</div>
                <div style="margin-bottom: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">Seller Name</div>
                <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px;">  
                <div style="margin-bottom: 10px; margin-top: 10px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">Items</div>
                <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">1x - item 1 - P 50</div>
                <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">1x - item 1 - P 50</div>
                <div style="margin-bottom: 5px; margin-top: 5px;text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">1x - item 1 - P 50</div>
                <hr style="border-top: 2px dotted rgba(0, 0, 0, 1); margin-top: 10px">  
                <div style="margin-bottom: 10px; margin-top: 10px;text-align: center; font-size: 1rem; font-family: Loew-ExtraBold !important;">TOTAL AMOUNT: P 00.00</div>
                <hr style="border-top: 2px dotted rgba(0, 0, 0, 1);">  
                <div style="margin-bottom: 5px; margin-top: 5px; text-align: center; font-size: 0.8rem; font-family: Loew-Medium !important;">sent via email. click anywhere to close.</div>                
            </div>
        </div> -->
    </div>
    
    
    
    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    <nav class="navbar">
        <!-- LOGO -->

        <div class="nav-left">
            <div class="menu">
                <a href="#"
                    class="logo"><?php if ($organization == "Individual") {
                        echo htmlspecialchars(strtoupper($name));
                    } else {
                        echo htmlspecialchars(strtoupper($organization));
                    } ?></a>

                <form class="search-bar ">
                    <input id="search" type="text" autocomplete="off" placeholder="Search Products...">
                    <i class="bi bi-x-lg search-meron hide" style="cursor: pointer;"></i>
                    <i class="bi bi-search search-empty"></i>
                </form>

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
        <div class="left-nav-icon button selected" title="HOME" onclick="homeButton()"><i class="bi bi-house"></i>HOME
        </div>
        <div class="left-nav-icon button cart-icon" title="CART" onclick="cartButton()"><i class="bi bi-cart"></i>CART
        </div>
        <div class="left-nav-icon button" title="INVENTORY" onclick="window.location.href='pages/inventory.php'"><i
                class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" onclick="window.location.href='pages/logs.php'"><i
                class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button" title="REPORTS" onclick="window.location.href='pages/reports.php'"><i
                class="bi bi-bar-chart-line"></i>REPORTS</div>
        <div class="left-nav-icon button" title="SETTINGS" onclick="window.location.href='pages/settings.php'"><i
                class="bi bi-gear"></i>SETTINGS</div>
        <div class="left-nav-icon button" title="LOGOUT" onclick="window.location.href='pages/inventory.php'"><i
                class="bi bi-box-arrow-left"></i>LOGOUT</div>
    </div>

    <div class="main-interface with-navbar">
        <div class="left-panel">
            <div class="left-panel-content shadow unselectable">
                <div class="left-nav-upper">
                    <div class="left-nav-icon button selected" onclick="homeButton()"><i class="bi bi-house"></i>HOME
                    </div>
                    <div class="left-nav-icon button cart-icon" onclick="cartButton()"><i class="bi bi-cart"></i>CART
                    </div>
                    <div class="left-nav-icon button" onclick="window.location.href='pages/inventory.php'"><i
                            class="bi bi-boxes" href="../pages/inventory.php"></i>INVENTORY</div>
                    <div class="left-nav-icon button" onclick="window.location.href='pages/logs.php'"><i
                            class="bi bi-journal-text"></i>LOGS</div>
                    <div class="left-nav-icon button" onclick="window.location.href='pages/reports.php'"><i
                            class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <div class="left-nav-icon button" onclick="window.location.href='pages/settings.php'"><i
                            class="bi bi-gear"></i>SETTINGS</div>
                </div>

                <div class="left-nav-lower">
                    <div class="left-nav-icon button" onclick="window.location.href='index.php?logout=1'"><i
                            class="bi bi-box-arrow-left"></i>LOGOUT</div>
                </div>

            </div>
        </div>

        <div class="center-panel">
            <div class="center-panel-content">

                <div class="category-panel shadow unselectable">
                    <div class="category-button selected">All</div>
                    <?php
                    $firstCategory = true;
                    foreach ($categories as $category) {
                        if ($firstCategory) {
                            $firstCategory = false;
                            continue;
                        }
                        ?>
                        <div class="category-button"><?php echo htmlspecialchars($category['name']); ?></div>
                    <?php } ?>

                </div>

                <div class="products-panel unselectable">

                    <?php
                    foreach ($items as $item) {
                        ?>

                        <div class="product-card shadow" itemID='<?php echo htmlspecialchars($item['id']); ?>'>
                            <div class="card-add-to-cart"><i class="bi bi-plus-circle-fill" title="Add to Cart"></i></div>
                            <div class="product-icon"><img
                                    src="assets/images/<?php echo htmlspecialchars($item['image_name']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"></div>
                            <div class="product-card-desc" category="Stickers">
                                <div class="product-name"
                                    title="<?php echo htmlspecialchars($item['name'] . "\n" . $item['stock'] . " items left."); ?>">
                                    <span><?php echo htmlspecialchars($item['name']); ?></span></div>
                                <div class="product-price">P <?php echo htmlspecialchars($item['price']); ?></div>
                            </div>
                        </div>

                    <?php } ?>


                    <!-- to avoid stretching-->
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                    <div class="product-card shadow invisible"></div>
                </div>

                <div class="settings-panel shadow unselectable hide" style="width: 100% !important;">
                    <div class="category-button">Aldddddddddddddddddsdfgdfgsl</div>
                </div>


            </div>
        </div>

        <div class="right-panel">
            <div class="right-panel-content">
                <div class="cart-panel shadow">
                    <div class="cart-header">
                        <input class="customer-name-input" id="search-user" type="text" autocomplete="off"
                            placeholder="Customer ID...">
                        <div class="scan-id confirm unselectable" id="scan-id" style="cursor: pointer;">SCAN ID</div>
                        <div class="scan-id confirm unselectable" style="display: none;" id="search-id"
                            style="cursor: pointer;">SEARCH</div>
                    </div>

                    <div style="height:1.5px; background-color: rgba(0, 0, 0, 0.082); width: 100%; "></div>

                    <div class="cart-items" id="cart-item-holder">

                        <!-- <div class="cart-item-banner">
                            <div class="cart-item-banner-base">
                                <div class="cart-item-banner-base-left">
                                    <i class="bi bi-caret-right" style="color: rgba(0, 0, 0, 0.39);"></i>
                                    <div class="cart-item-quantity">2x</div>
                                    <div class="cart-item-name">NAVIA STICKER</div>
                                </div>
                               
                                <div class="cart-item-banner-base-right">
                                    <div class="cart-item-price">P 69.00</div>
                                    <i class="bi bi-x-circle-fill" style="color: rgba(0, 0, 0, 0.39);"></i>
                                </div>
                               
                            </div>

                            <div class="cart-item-banner-drop hide">
                            asdasd
                            </div>
                            
                        </div> -->


                    </div>
                </div>

                <div class="details-panel shadow">
                    <div class="details-panel-upper">

                        <div class="transaction-details-banner">
                            <div class="transaction-details-banner-base">
                                <div class="transaction-details-banner-base-left">
                                    EMAIL:
                                </div>

                                <div class="transaction-details-banner-base-right">
                                    <div id="email-holder"></div>
                                </div>
                            </div>
                        </div>

                        <div class="transaction-details-banner">
                            <div class="transaction-details-banner-base">
                                <div class="transaction-details-banner-base-left">
                                    PAYMENT METHOD
                                </div>

                                <select class="transaction-details-banner-base-right"
                                    style="cursor: pointer; border:none; font-size: larger; text-align: right;  padding-right: 5px;"
                                    name="pMethod" id="pMethod" title="Select Payment Method">
                                    <option value="Cash">Cash</option>
                                    <option value="Gcash">Gcash</option>
                                    <option value="Other">Other</option>
                                </select>

                            </div>
                        </div>

                        <div class="transaction-details-banner" style="margin-bottom: 15px;">
                            <div class="transaction-details-banner-base">
                                <div class="transaction-details-banner-base-left">
                                    TOTAL AMOUNT:
                                </div>

                                <div class="transaction-details-banner-base-right">
                                    <div class="total-amount" id="total-amount">P 0.00</div>
                                </div>
                            </div>
                        </div>

                        <div class="details-panel-lower">
                            <div class="confirm-group">
                                <div class="confirm-button cancel unselectable" style="cursor:pointer;"
                                    onclick="ClearInput()">CANCEL</div>
                                <div class="confirm-button confirm unselectable" style="cursor:pointer;"
                                    onclick="ConfirmCheckOut()">CONFIRM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/search.js" id="rendered-js"></script>
        <script type="text/javascript" src="js/customize.js" id="rendered-js"></script>
        <script type="text/javascript" src="js/navigation.js" id="rendered-js"></script>
        <script type="text/javascript" src="js/transaction.js" id="rendered-js"></script>

</body>

</html>
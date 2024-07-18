<?php

require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

if ($_SESSION['role'] == "student") {
    header('location: login.php');
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    unset($_SESSION['org_role']);
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    unset($_SESSION['org_role']);
    header("location: login.php");
}

require 'getUserDetails.php';

if ($organization_id == '1') {
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' AND user_id = '$_SESSION[user_id]' ORDER BY stock DESC";
} else {
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' OR organization_id = '0' ORDER BY stock DESC";
}

$result = mysqli_query($conn, $sql);

$items = mysqli_fetch_all($result, MYSQLI_ASSOC);

$sql = "SELECT * FROM item_category";

$result = mysqli_query($conn, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

function formatMoney($amount){
 $amount = (double) $amount;

 return number_format($amount, 2, '.', ',');
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
    <title>Prototype</title>
</head>

<body>
    
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
                    class="logo"><?php 
                    if($_SESSION['role'] == "master"){
                        echo htmlspecialchars("MASTER");
                    } else {
                        if ($organization_name == "Individual") {
                            echo htmlspecialchars(strtoupper($name));
                        } else{
                            echo htmlspecialchars(strtoupper($organization_name));
                        }
                    }
                     ?></a>
                
                <form class="search-bar ">
                    <input id="search" type="text" autocomplete="off" placeholder="Search products...">
                    <i class="bi bi-search search-empty"></i>
                    <i class="bi bi-x-lg search-meron" style="cursor: pointer; display: none;"></i>
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
        <div class="left-nav-icon button <?php if(!isset($_GET['cart'])) {echo "selected"; }?>" title="HOME" onclick="homeButton()"><i class="bi bi-house"></i>HOME
        </div>
        <div class="left-nav-icon button cart-icon <?php if(isset($_GET['cart'])) {echo "selected"; }?>" title="CART" onclick="cartButton()"><i class="bi bi-cart"></i>CART
        </div>
        <div class="left-nav-icon button" title="INVENTORY" onclick="window.location.href='inventory.php'"><i
                class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" onclick="window.location.href='logs.php'"><i
                class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button" title="REPORTS" onclick="window.location.href='reports.php'"><i
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

    <div class="main-interface with-navbar">
        <div class="left-panel">
            <div class="left-panel-content shadow unselectable">
                <div class="left-nav-upper">
                    <div class="left-nav-icon button selected" onclick="homeButton()"><i class="bi bi-house"></i>HOME
                    </div>
                    <div class="left-nav-icon button cart-icon" onclick="cartButton()"><i class="bi bi-cart"></i>CART
                    </div>
                    <div class="left-nav-icon button" onclick="window.location.href='inventory.php'"><i
                            class="bi bi-boxes"></i>INVENTORY</div>
                    <div class="left-nav-icon button" onclick="window.location.href='logs.php'"><i
                            class="bi bi-journal-text"></i>LOGS</div>
                    <div class="left-nav-icon button" onclick="window.location.href='reports.php'"><i
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

                <div class="products-panel unselectable"> <!--  . "\n" . $item['stock'] . " items left."-->

                    <?php
                    foreach ($items as $item) {
                        if((int)$item['stock'] <= 0){
                            continue;
                        }
                        ?>

                        <div class="product-card shadow" itemID='<?php echo htmlspecialchars($item['id']); ?>' 
                        title="<?php echo htmlspecialchars($item['name']); ?>"
                        stock="<?php echo htmlspecialchars($item['stock']); ?>" >
                            <div class="card-add-to-cart"><i class="bi bi-plus-circle-fill" title="Add to Cart"></i></div>
                            <div class="product-icon"><img
                                    src="assets/images/<?php echo htmlspecialchars($item['image_name']); ?>"
                                    alt="<?php echo htmlspecialchars($item['name']); ?>"></div>
                            <div class="product-card-desc" category="<?php echo htmlspecialchars($item['category_name']); ?>">
                                <div class="product-name">
                                    <span><?php echo htmlspecialchars($item['name']); ?></span></div>
                                <div class="product-price">P <?php echo htmlspecialchars(formatMoney($item['price'])); ?></div>
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
                            placeholder="Customer Info...">
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
                            
                            <div class="cart-item-banner-drop" style="margin-top: 15px;">
                                <div class="cart-item-banner-base-left">
                                    <select class="transaction-details-banner-base-right"
                                        style="color: var(--card-text-color); cursor: pointer; border:none; font-size: larger; background-color: rgba(0,0,0,0); margin: 0 25px;"
                                        name="pMethod" id="pMethod" title="Select Payment Method">
                                        <option value="" disabled selected>Select Discount</option>
                                        <option value="">Buy 4 Get 1 Free</option>
                                        <option value="">10% Discount</option>
                                        <option value="">20% Discount</option>
                                    </select>
                                </div>
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
                                    style="color: var(--card-text-color); cursor: pointer; border:none; font-size: larger; text-align: right;  padding-right: 5px; background-color: rgba(0,0,0,0);"
                                    name="pMethod" id="pMethod" title="Select Payment Method">
                                    <option style="background-color: rgb(125, 125, 125);" value="Cash">Cash</option>
                                    <option style="background-color: rgb(125, 125, 125);" value="Gcash">Gcash</option>
                                    <option style="background-color: rgb(125, 125, 125);" value="Other">Other</option>
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
                                <div id="confirm-button" class="confirm-button confirm unselectable" style="cursor:pointer;"
                                    onclick="ConfirmCheckOut()">CONFIRM</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/search.js" id="rendered-js"></script>
        <script type="text/javascript" src="js/navigation.js" id="rendered-js"></script>
        <script type="text/javascript" src="js/transaction.js" id="rendered-js"></script>

        <?php if(isset($_GET['cart'])) {echo "<script> cartButton(); </script>"; }?>
    

</body>

</html>
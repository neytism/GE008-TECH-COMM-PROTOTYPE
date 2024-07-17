<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}


require 'getUserDetails.php';

if ($organization_id == '1'){
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' AND user_id = '$_SESSION[user_id]'";
} else{
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' OR organization_id = '0'";
}

$result = mysqli_query($conn, $sql);

$items = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/ciit.png">
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Inventory</title>
</head>
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
    
                <form class="search-bar ">
                    <input id="search" type="text" autocomplete="off" placeholder="Search Inventory...">
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
        <div class="left-nav-icon button" title="HOME" onclick="goToPage('index.php'); homeButton();"><i class="bi bi-house"></i>HOME
        </div>
        <div class="left-nav-icon button cart-icon" title="CART" onclick="goToPage('index.php?cart=1'); cartButton();"><i class="bi bi-cart"></i>CART
        </div>
        <div class="left-nav-icon button selected" title="INVENTORY" onclick="window.location.href='inventory.php'"><i
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
    
    <div class="main-interface with-navbar" >
        <div class="add-new-product shadow" title="Add new product"><i style="height: 100%; display: flex; align-items: center; justify-content: center;" class="bi bi-plus-lg"></i></div>
        <div class="left-panel">
            <div class="left-panel-content shadow unselectable">
                <div class="left-nav-upper">
                    <div class="left-nav-icon button" onclick="window.location.href='index.php'"><i class="bi bi-house"></i>HOME
                    </div>
                    <div class="left-nav-icon button cart-icon" onclick="window.location.href='index.php'"><i class="bi bi-cart"></i>CART
                    </div>
                    <div class="left-nav-icon button selected" onclick="window.location.href='inventory.php'"><i
                            class="bi bi-boxes" ></i>INVENTORY</div>
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
        
        <div class="center-panel" style="margin-right: 15px; width: 100%;">
            <div class="center-panel-content">
                
                <div class="category-panel shadow unselectable">
                    <div class="category-button selected">All</div>
                    <div class="category-button">Stickers</div>
                    <div class="category-button">Pins</div>
                    <div class="category-button">Shirts</div>
                    <div class="category-button">Food</div>
                    <div class="category-button">Drinks</div>
                    <div class="category-button">Lanyard</div>
                    <div class="category-button">Keycaps</div>
                    <div class="category-button">Keychain</div>
                </div>
                
                <div class="products-panel unselectable">
                
                    
                    <table style="background-color: var(--card-color); color: var(--card-text-color); border-radius: 10px; width: 100%; text-align: left; padding: 15px; margin-bottom: 300px;">

                        <thead >
                            <tr >
                                <th scope="col" >ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Item Name</th>
                                <th scope="col">Category</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Price</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        
                        <tbody >
                            <tr><td colspan="7"><br><hr style="border-top: 1px solid rgba(0, 0, 0, 0.151);"></td></tr>
                            
                            <?php
                            foreach ($items as $item) {
                                ?>

                                 <tr class="inventory-row" style="height: 50px;">
                                    <th class="inventory-id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;"><?php echo htmlspecialchars($item['id']); ?></th>
                                    <td style="width:130px; min-width: 130px; max-width: 130px; height: 75px; padding: 0 15px;"><img src="assets/images/<?php echo htmlspecialchars($item['image_name']); ?>" style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"></td>
                                    <th class="inventory-name" style="padding-right: 30px; padding-bottom: 10px;"><?php echo htmlspecialchars($item['name']); ?></th>
                                    <th class="inventory-category" style="width: 120px ; min-width: 120px; max-width: 120px;"><?php echo htmlspecialchars($item['category_name']); ?></th>
                                    <th style="width: 75px ; min-width: 75px; max-width: 75px;"><?php echo htmlspecialchars($item['stock']); ?></th>
                                    <th style="width: 100px ; min-width: 100px; max-width: 100px;" >P <?php echo htmlspecialchars($item['price']); ?></th>
                                    <th style="width: 50px ; min-width: 50px; max-width: 50px; font-size: 1.5rem; text-align: center; cursor: pointer;" onclick="window.location.href='editProduct.php?productID=<?php echo htmlspecialchars($item['id']); ?>'"><i title="Edit Item <?php echo htmlspecialchars($item['id']); ?>" class="bi bi-pencil-square"></i></th>
                                </tr>

                            <?php } ?>

                            <!-- <tr class="inventory-row" style="height: 50px;">
                                <th class="inventory-id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;">AXS-003</th>
                                <td style="width:130px; min-width: 130px; max-width: 130px; height: 75px; padding: 0 15px;"><img src="assets/images/gato.png" style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"></td>
                                <th class="inventory-name" style="padding-right: 30px; padding-bottom: 10px;">CIIT sticker with FREE Tuition Fee</th>
                                <th class="inventory-category" style="width: 120px ; min-width: 120px; max-width: 120px;">Stickers</th>
                                <th style="width: 75px ; min-width: 75px; max-width: 75px;">69</th>
                                <th style="width: 100px ; min-width: 100px; max-width: 100px;" >P 69.99</th>
                                <th style="width: 50px ; min-width: 50px; max-width: 50px; font-size: 1.5rem; text-align: center; cursor: pointer;"><i title="Edit Item AXS-003" class="bi bi-pencil-square"></i></th>
                            </tr> -->
                            
                            <tr class="no-results hide" style="height: 50px;">
                                <th colspan="9" style="width:100px ; min-width: 100px; max-width: 100px; text-align: center;">No Results.</th>
                            </tr>
                        
                        </tbody>

                    </table>
                    
                    
                    
                    <!-- to avoid stretching
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    <div class="product-card shadow invisible" ></div>
                    -->
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
    
</body>
</html>
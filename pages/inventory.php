<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: pages/login.php');
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


$sql = "SELECT organization FROM users WHERE id = '$_SESSION[user_id]'";

$result = $conn->query($sql);

if ($row = $result->fetch_assoc()) {
    $organization_id = $row["organization"];
}

if ($organization_id == '1'){
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id' AND user_id = '$_SESSION[user_id]'";
} else{
    $sql = "SELECT items.*, item_category.name AS category_name FROM items JOIN item_category ON items.category_id = item_category.id WHERE organization_id = '$organization_id'";
}

$result = mysqli_query($conn, $sql);

$items = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/qiqi.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Inventory</title>
</head>
<body>
    
    <button class="test-button"> TEST </button>

    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    <nav class="navbar">
        <!-- LOGO -->
    
        <div class="nav-left">
            <div class="menu">
                <a href="#" class="logo">CIIT ORG</a>
    
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
                <li><a href="https://www.youtube.com/">SELLER NAME</a></li>
            </div>
        </div>
    
    </nav>
    
    <div class="mobile-nav shadow">
        <div class="left-nav-icon button" title="HOME" onclick="homeButton()"><i class="bi bi-house"></i>HOME</div>
        <div class="left-nav-icon button cart-icon" title="CART" onclick="cartButton()"><i class="bi bi-cart"></i>CART</div>
        <div class="left-nav-icon button selected" title="INVENTORY" ><i class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" ><i class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button" title="REPORTS" ><i class="bi bi-bar-chart-line"></i>REPORTS</div>
        <div class="left-nav-icon button" title="SETTINGS" ><i class="bi bi-gear"></i>SETTINGS</div>
        <div class="left-nav-icon button" title="LOGOUT" ><i class="bi bi-box-arrow-left"></i>LOGOUT</div>
    </div>
    
    <div class="main-interface with-navbar" >
        <div style=" margin: 25px; border-radius: 35px; text-align: center; position: fixed; bottom: 0; right: 0; font-size: 2rem; color: white; background-color: var(--confirm-color); height: 70px; width: 70px; cursor: pointer;" class="shadow" title="Add new product" onclick="window.location.href='addProduct.php'"><i style="height: 100%; display: flex; align-items: center; justify-content: center;" class="bi bi-plus-lg"></i></div>
        <div class="left-panel" >
            <div class="left-panel-content shadow unselectable" >
                <div class="left-nav-upper">
                    <div class="left-nav-icon button" onclick="homeButton()"><i class="bi bi-house"></i>HOME</div>
                    <div class="left-nav-icon button cart-icon" onclick="cartButton()"><i class="bi bi-cart"></i>CART</div>
                    <div class="left-nav-icon button selected"><i class="bi bi-boxes"></i>INVENTORY</div>
                    <div class="left-nav-icon button"><i class="bi bi-journal-text"></i>LOGS</div>
                    <div class="left-nav-icon button"><i class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <div class="left-nav-icon button"><i class="bi bi-gear"></i>SETTINGS</div>
                </div>
                
                <div class="left-nav-lower">
                    <div class="left-nav-icon button"><i class="bi bi-box-arrow-left"></i>LOGOUT</div>
                </div>

            </div>
        </div>
        
        <div class="center-panel" style="margin-right: 15px; width: 100%;">
            <div class="center-panel-content" >
                
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
                
                    
                    <table style="background-color: white; border-radius: 10px; width: 100%; text-align: left; padding: 15px; ">

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
                                    <td style="width:130px; min-width: 130px; max-width: 130px; height: 75px; padding: 0 15px;"><img src="../assets/images/<?php echo htmlspecialchars($item['image_name']); ?>" style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"></td>
                                    <th class="inventory-name" style="padding-right: 30px; padding-bottom: 10px;"><?php echo htmlspecialchars($item['name']); ?></th>
                                    <th class="inventory-category" style="width: 120px ; min-width: 120px; max-width: 120px;"><?php echo htmlspecialchars($item['category_name']); ?></th>
                                    <th style="width: 75px ; min-width: 75px; max-width: 75px;"><?php echo htmlspecialchars($item['stock']); ?></th>
                                    <th style="width: 100px ; min-width: 100px; max-width: 100px;" >P <?php echo htmlspecialchars($item['price']); ?></th>
                                    <th style="width: 50px ; min-width: 50px; max-width: 50px; font-size: 1.5rem; text-align: center; cursor: pointer;" onclick="window.location.href='editProduct.php?productID=<?php echo htmlspecialchars($item['id']); ?>'"><i title="Edit Item <?php echo htmlspecialchars($item['id']); ?>" class="bi bi-pencil-square"></i></th>
                                </tr>

                            <?php } ?>

                            <!-- <tr class="inventory-row" style="height: 50px;">
                                <th class="inventory-id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;">AXS-003</th>
                                <td style="width:130px; min-width: 130px; max-width: 130px; height: 75px; padding: 0 15px;"><img src="../assets/images/gato.png" style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"></td>
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
    <script type="text/javascript" src="../js/search.js" id="rendered-js"></script>
    
</body>
</html>
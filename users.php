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

function getUserIdFormatted($id, $length) {
    return str_pad($id, $length, '0', STR_PAD_LEFT);
}

function getUserNumberFormatted($number) {
    $firstPart = substr($number, 0, 2);
    $secondPart = substr($number, 2, 2);
    $thirdPart = substr($number, 4,4);
    
    return $firstPart . "-". $secondPart ."-". $thirdPart;
}


if ($_SESSION['org_role'] == "admin") $sql = "SELECT uo.*, u.name, u.student_number, u.username, u.email, o.code FROM user_organizations AS uo JOIN organizations AS o ON uo.organization_id = o.id JOIN users AS u ON uo.user_id = u.id WHERE uo.organization_id = '$organization_id'";
if ($_SESSION['role'] == "master") $sql = "SELECT uo.*, u.name, u.student_number, u.username, u.email, o.code FROM user_organizations AS uo JOIN organizations AS o ON uo.organization_id = o.id JOIN users AS u ON uo.user_id = u.id";

$result = mysqli_query($conn, $sql);

$users = mysqli_fetch_all($result, MYSQLI_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="assets/images/ciit.png">
    <link rel="stylesheet" type="text/css" href="css/style.php">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Users</title>
</head>
<body>

    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>
    
    <?php if($_SESSION['role'] == 'master') echo('<button class="hide" style="position: absolute; z-index: 100; bottom: 0; right:0; height: 50px; width: 100px; margin: 20px;" onclick="masterAddUser()"> Add user </button>
    <div id="masterAddUserHolder"></div>'); ?>

    <div id="masterAddUserHolderParent">
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
                    <input id="search" type="text" autocomplete="off" placeholder="Search Users...">
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
        <div class="left-nav-icon button" title="INVENTORY" onclick="window.location.href='inventory.php'"><i
                class="bi bi-boxes"></i>INVENTORY</div>
        <div class="left-nav-icon button" title="LOGS" onclick="window.location.href='logs.php'"><i
                class="bi bi-journal-text"></i>LOGS</div>
        <div class="left-nav-icon button" title="REPORTS" onclick="window.location.href='reports.php'"><i
                class="bi bi-bar-chart-line"></i>REPORTS</div>
        <?php 
        if($_SESSION['org_role'] == 'admin' || $_SESSION['role'] == 'master'){
        ?><div class="left-nav-icon button selected" title="USERS" onclick="window.location.href='users.php'"><i
                class="bi bi-person"></i>USERS</div><?php
        }
        ?>
        <div class="left-nav-icon button" title="SETTINGS" onclick="window.location.href='settings.php'"><i
                class="bi bi-gear"></i>SETTINGS</div>
            
        <div class="left-nav-icon button" title="LOGOUT" onclick="window.location.href='index.php?logout=1'"><i
                class="bi bi-box-arrow-left"></i>LOGOUT</div>
    </div>
    
    <div class="main-interface with-navbar" >
        <?php if($_SESSION['org_role'] == 'admin') { ?> <div class="add-new-product shadow hide" title="Add New Seller" onclick=""><i style="height: 100%; display: flex; align-items: center; justify-content: center;" class="bi bi-plus-lg"></i></div>
        <?php } ?>
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
                    <div class="left-nav-icon button" onclick="window.location.href='reports.php'"><i
                            class="bi bi-bar-chart-line"></i>REPORTS</div>
                    <?php 
                    if($_SESSION['org_role'] == 'admin' || $_SESSION['role'] == 'master'){
                    ?><div class="left-nav-icon button selected" onclick="window.location.href='users.php'"><i
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
                    
                    <div class="inventory-card shadow hide" itemID='1'>
                        <div class="inventory-icon"><img src="assets/images/ciit.png" alt="Product Image"></div>
                        <div class="inventory-card-desc" category="Stickers">
                            <div class="inventory-name" title="CIIT sticker with FREE Tuition Fee"><span>CIIT sticker with FREE Tuition Fee</span></div>
                            <div class="inventory-price">P 25.00</div>
                        </div>
                    </div>

                    <div style="width: 100%; border-radius: 10px;  padding: 15px; background-color: var(--card-color); ">

                        <table style="color: var(--card-text-color) ; width: 100%; text-align: left; border-collapse: collapse;">
                            
                            <thead >
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Organization</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Email</th>
                                    
                                </tr>
                            </thead>
                            
                            <tbody >
                                <tr><td colspan="7"><br><hr style="border-top: 1px solid rgba(0, 0, 0, 0.151);"><br></td></tr>
                                
                                <?php
                                    $previous_user = array();
                                    $row_count = 0;

                                    foreach ($users as $user) {
                                        if ($previous_user == null) $previous_user = array();
                                        if ($previous_user !== $user['user_id']) $row_count++;
                                        ?>
                                        
                                        <tr class="log-row" style="height: 50px; vertical-align: top; background: var(--card-color-<?php echo $row_count % 2 == 0 ? 'darker' : ''; ?>);">
                                            <th class="id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;">
                                                <?php if ($previous_user !== $user['user_id']) {
                                                    echo htmlspecialchars(getUserIdFormatted($user['user_id'], 4));
                                                } else {
                                                    echo '&nbsp;';
                                                } ?>
                                            </th>
                                            <th class="student-id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;">
                                                <?php if ($previous_user !== $user['user_id']) {
                                                    echo htmlspecialchars(getUserNumberFormatted($user['student_number']));
                                                } else {
                                                    echo '&nbsp;';
                                                } ?>
                                            </th>
                                            <th class="name" style="padding-right: 30px;">
                                                <?php if ($previous_user !== $user['user_id']) {
                                                    echo htmlspecialchars($user['name']);
                                                    if ($user['user_id'] == $_SESSION['user_id'])
                                                        echo htmlspecialchars(' ***');
                                                } else {
                                                    echo '&nbsp;';
                                                } ?>
                                            </th>
                                            <th class="organization" style="width: 150px ; min-width: 150px; max-width: 150px;">
                                                <?php if ($_SESSION['role'] == "master") {
                                                    if ($user['role'] != 'master') {
                                                        echo htmlspecialchars($user['code']);
                                                    } else {
                                                        echo htmlspecialchars("- - -");
                                                    }
                                                } else {
                                                    echo htmlspecialchars($user['code']);
                                                } ?>
                                                <br>
                                            </th>
                                            <th class="role" style="width: 100px ; min-width: 100px; max-width: 100px;">
                                                <?php if ($user['organization_id'] == '1' || $user['user_id'] == $_SESSION['user_id']) {
                                                } else { ?>
                                                    <select id="role" onchange="changeValue(this, '<?php echo ($user['user_id']) ?>', '<?php echo ($user['organization_id']) ?>' )">
                                                        <option value="admin" <?php if ($user['role'] == 'pending') echo 'selected' ?>>admin</option>
                                                        <option value="seller" <?php if ($user['role'] == 'seller') echo 'selected' ?>>seller</option>
                                                    </select>
                                                <?php } ?>
                                            </th>
                                            <th class="role" style="width: 100px ; min-width: 100px; max-width: 100px;">
                                                <?php if ($user['user_id'] == $_SESSION['user_id']) {
                                                } else { ?>
                                                    <select id="status" onchange="changeValue(this, '<?php echo ($user['user_id']) ?>', '<?php echo ($user['organization_id']) ?>' )">
                                                        <option value="pending" <?php if ($user['status'] == 'pending') echo 'selected' ?>>pending</option>
                                                        <option value="approved" <?php if ($user['status'] == 'approved') echo 'selected' ?>>approved</option>
                                                    </select>
                                                <?php } ?>
                                            </th>
                                            <th class="email" style="width: 300px ; min-width: 300px; max-width: 300px;">
                                                <?php if ($previous_user !== $user['user_id']) {
                                                    echo htmlspecialchars($user['email']);
                                                } else {
                                                    echo '&nbsp;';
                                                } ?>
                                            </th>
                                        </tr>

                                        <?php
                                        $previous_user = $user['user_id'];
                                    }
                                ?>
                                
                                <!-- <tr class="log-row" style="height: 50px;">
                                    <th class="log-id" style="width:100px ; min-width: 100px; max-width: 100px; word-wrap:break-word;">LOG-001</th>
                                    <th class="log-category" style="width: 120px ; min-width: 120px; max-width: 120px;">User</th>
                                    <th class="log-user" style="width: 120px ; min-width: 120px; max-width: 120px;">12345678</th>
                                    <th class="log-details" style="padding-right: 30px;">Logged In.</th>
                                    <th class="log-datetime" style="width: 200px ; min-width: 200px; max-width: 200px;">2024-07-01 06:15:00</th>
                                </tr> -->
                                
                                <tr class="no-results hide" style="height: 50px;">
                                    <th colspan="5" class="log-id" style="width:100px ; min-width: 100px; max-width: 100px; text-align: center;">No Results.</th>
                                </tr>

                            </tbody>

                        </table>

                    </div>
                    
                   
                    
                    
                    
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
    <script type="text/javascript" src="js/updateUser.js" id="rendered-js"></script>

    <?php if($_SESSION['role'] == 'master') echo('<script type="text/javascript" src="js/masterScript.js" id="rendered-js"></script>'); ?>

</body>
</html>
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

$temp_id = isset($_GET['productID']) ? $_GET['productID'] : null;

$sql = "SELECT * FROM items WHERE id = '$temp_id'";

$result = mysqli_query($conn, $sql);

$currentItem = $result->fetch_assoc();

$sql = "SELECT * FROM item_category";

$result = mysqli_query($conn, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Function to get category name by ID
function getCategoryNameById($categories, $id) {
    foreach ($categories as $category) {
        if ($category['id'] == $id) {
            return $category['name'];
        }
    }
    return null;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array(
        'item_name' => '',
        'itemImage' => '',
        'itemPrice' => '',
        'itemStock' => '',
        'itemCategory' => ''
    );
    
    $itemID = $_POST['itemID'];

    $sql = "SELECT * FROM items WHERE id = '$itemID'";

    $result = mysqli_query($conn, $sql);
    
    $currentItem = $result->fetch_assoc();
    
    $item_name = $_POST['item_name'];
    $itemPrice = $_POST['itemPrice'];
    $itemStock = $_POST['itemStock'];
    $itemCategory = $_POST['itemCategory'];
    $imageChanged = false;
    if (isset($_FILES['itemImage'])) {
        $itemImage = $_FILES['itemImage'];
        $imageChanged = true;
    } 

    $sql = "SELECT * FROM users WHERE id = '$_SESSION[user_id]'";

    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        $organization_id = $row["organization"];
        $user_name = $row["name"];
    }

    $sql = "SELECT * FROM organizations WHERE id = '$organization_id'";

    $result = $conn->query($sql);

    if ($row = $result->fetch_assoc()) {
        $organization_code = $row["code"];
    }

    
    if (empty($item_name)) {
        $item_name = $currentItem['name'];
    } else {
        if (strlen($item_name) > 200) {
            $errors['item_name'] = '-Invalid, too long.';
        }
    }

    if (empty($itemPrice)) {
       $itemPrice = $currentItem['price'];
    }

    if (empty($itemStock)) {
        $itemStock = $currentItem['stock'];
    }

    if (empty($itemCategory)) {
        $itemCategory = $currentItem['category_id'];
    }

    $sql = "SELECT id FROM items WHERE id = '$currentItem[id]'";
    $result = mysqli_query($conn, $sql);
    
    if ($row = $result->fetch_assoc()) {
        $itemCode = $row["id"];
    }

    if (empty($itemImage['name'])) {
        $itemImage = $currentItem['image_name'];
    } else {
        $base_dir = "assets/images/";
        $target_dir = "../" . $base_dir;
        $target_file = $target_dir . basename($itemImage["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newFileName = $itemCode . "." . $imageFileType;
        $newFilePath = $target_dir . $newFileName;
        $relativeFilePath = $base_dir . $newFileName;
        
        if ($itemImage["size"] > 5000000) {
            $errors['itemImage'] = '-File is too large';
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $errors['itemImage'] = '-Only JPG, JPEG, PNG & GIF files are allowed';
        }

        if (!array_filter($errors)) {
            if (move_uploaded_file($itemImage["tmp_name"], $newFilePath)) {
                $itemImage = $newFileName;
            } else {
                $errors['itemImage'] = '-There was an error uploading your file';
            }
        }
    }



    if (array_filter($errors)) {
        echo implode("\n", array_filter($errors));
    } else {
        
        $itemCode = mysqli_real_escape_string($conn, $itemCode);
        $item_name = mysqli_real_escape_string($conn, $item_name);
        $itemPrice = mysqli_real_escape_string($conn, $itemPrice);
        $itemStock = mysqli_real_escape_string($conn, $itemStock);
        $organization_id = mysqli_real_escape_string($conn, $organization_id);

        $changes = "";
        
        if($item_name != $currentItem['name'] || $itemPrice != $currentItem['price'] || $itemStock != $currentItem['stock'] || $itemCategory != $currentItem['category_id'] || $imageChanged){
        
            if($item_name != $currentItem['name']){
                $changes = $changes . "Item name from " . $currentItem['name'] . " to " . $item_name . ". ";
                $sql = "UPDATE items SET name='$item_name' WHERE id='$currentItem[id]'";
                mysqli_query($conn, $sql);
            }

            if($imageChanged){
                $changes = $changes . "Changed image. ";
                $sql = "UPDATE items SET name='$item_name' WHERE id='$currentItem[id]'";
                mysqli_query($conn, $sql);
            }
        
            if($itemStock != $currentItem['stock']){
                $changes = $changes . "Stock from " . $currentItem['stock'] . " to " . $itemStock . ". ";
                $sql = "UPDATE items SET stock='$itemStock' WHERE id='$currentItem[id]'";
                mysqli_query($conn, $sql);
            }

            if($itemPrice != $currentItem['price']){
                $itemPriceFormatted = number_format($itemPrice, 2, '.', '');
                $changes = $changes . "Price from P" . $currentItem['price'] . " to P" . $itemPriceFormatted . ". ";
                $sql = "UPDATE items SET price='$itemPrice' WHERE id='$currentItem[id]'";
                mysqli_query($conn, $sql);
            }

            if($itemCategory != $currentItem['category_id']){
                $currentCategoryName = getCategoryNameById($categories, $currentItem['category_id']);
                $newCategoryName = getCategoryNameById($categories, $itemCategory);
                
                $changes = $changes . "Category from " . $currentCategoryName . " to " . $newCategoryName . ". ";
                $sql = "UPDATE items SET category_id='$itemCategory' WHERE id='$currentItem[id]'";
                mysqli_query($conn, $sql);
            }
            
            $sql = "UPDATE items SET user_id='$_SESSION[user_id]' WHERE id='$currentItem[id]'";
            mysqli_query($conn, $sql);
        
            $sql = "INSERT INTO logs (type, userID, details) VALUES('inventory', '$_SESSION[user_id]', 'User $_SESSION[user_id] - $user_name updated item: $itemCode - $changes')";
            mysqli_query($conn, $sql);

            echo "success";
        } else{
            echo "nothing changed";
        }
        
        
    }


    return;
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../assets/images/qiqi.png">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Login</title>
    <style>
        select {
            -webkit-appearance: none !important;
            appearance: none !important;
        }
    </style>
</head>

<body>

    <div class="notification" id="notification">
        <p style="padding: 10px 20px; margin:0;">Item Added to Cart</p>
    </div>


    <div class="main-interface">

        <form id="loginForm">

            <div class="login-panel shadow">
                <div
                    style="margin-bottom: 10px; margin-top: 10px; text-align: center; font-size: 1.5rem; font-family: Loew-ExtraBold !important;">
                    ADD PRODUCT</div>

                <div style="height: 250px;">
                    <label for="inputItemImage" style="display: block; height: 100%; cursor: pointer;">
                        <img src="../assets/images/<?php echo htmlspecialchars($currentItem['image_name']); ?>"
                            style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"
                            title="Click to change image" id="displayImage">
                        <input type="file" accept="image/*" id="inputItemImage" style="display: none;">
                    </label>
                </div>

                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="text" id="inputitem_name" placeholder="Product Name" value="<?php echo htmlspecialchars($currentItem['name']); ?>" required>
                
                <select class="category-dropdown"
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px; cursor: pointer;"
                    name="category" id="inputCategory" title="Select Category">
                    <?php
                    $firstCategory = true;
                    $lastCategory = null;

                    foreach ($categories as $category) {
                        if ($firstCategory) {
                            $firstCategory = false;
                            $lastCategory = $category;
                            continue;
                        }
                        ?>
                        <option <?php if($category['id'] == $currentItem['category_id']) { echo htmlspecialchars("selected"); }; ?> value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php }

                    // Output the first category as the last one
                    if ($lastCategory) {
                        ?>
                        <option value="<?php echo htmlspecialchars($lastCategory['id']); ?>">
                            <?php echo htmlspecialchars($lastCategory['name']); ?>
                        </option>
                    <?php } ?>
                </select>
                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="number" id="inputItemStock" placeholder="Stock" value="<?php echo htmlspecialchars($currentItem['stock']); ?>" required>

                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="number" id="inputItemPrice" placeholder="Price" value="<?php echo htmlspecialchars($currentItem['price']); ?>" required>

                <div style="margin: 15px 25px; display: flex; gap: 15px;">
                    <div style="width: 50%; cursor: pointer;" class="confirm-button cancel"
                        onclick="window.location.href='inventory.php'">CANCEL</div>
                    <button type="submit" style="width: 50%; border: none; cursor: pointer;"
                        class="confirm-button confirm" onclick="checkAddProd(event, 'editProduct.php','<?php echo htmlspecialchars($currentItem['id']); ?>')">SAVE</button>
                </div>

                <div style="margin: 15px 25px; border-radius: 1rem; background-color: rgba(0, 0, 0, 0.466); display: none;"
                    class="confirm-button confirm" id="warningText">

                </div>

                </input>

        </form>


    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="../js/addProduct.js" id="rendered-js"></script>

</body>

</html>
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
}

if ($_SESSION['role'] == "student") {
    header('location: login.php');
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

$sql = "SELECT * FROM item_category";

$result = mysqli_query($conn, $sql);

$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = array(
        'item_name' => '',
        'itemImage' => '',
        'itemPrice' => '',
        'itemStock' => '',
        'itemCategory' => ''
    );

    $item_name = $_POST['item_name'];
    $itemPrice = $_POST['itemPrice'];
    $itemStock = $_POST['itemStock'];
    $itemCategory = $_POST['itemCategory'];
    if (isset($_FILES['itemImage'])) {
        $itemImage = $_FILES['itemImage'];
    }
    
    $sql = "SELECT * FROM users WHERE id = '$_SESSION[user_id]'";
    
    $result = $conn->query($sql);
    
    if ($row = $result->fetch_assoc()) {
        $organization_id = $row["active_organization"];
        $user_name = $row["name"];
    }
    
    $sql = "SELECT * FROM organizations WHERE id = '$organization_id'";
    
    $result = $conn->query($sql);
    
    if ($row = $result->fetch_assoc()) {
        $organization_code = $row["code"];
        $organization_name = $row["organization_name"];
    }
    

    if (empty($item_name)) {
        $errors['item_name'] = '-Item Name is required';
    } else {
        if (strlen($item_name) > 200) {
            $errors['item_name'] = '-Invalid, too long.';
        }
    }

    if (empty($itemPrice)) {
        $errors['itemPrice'] = '-Price is required';
    }

    if (empty($itemStock)) {
        $errors['itemStock'] = '-Stock is required';
    }

    if (empty($itemCategory)) {
        $errors['itemCategory'] = '-Category is required';
    }

    $sql = "SELECT id FROM items WHERE id LIKE '$organization_code%' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row['id'];
        $last_number = intval(substr($last_id, strlen($organization_code)));
        $itemCode = $organization_code . str_pad($last_number + 1, 3, '0', STR_PAD_LEFT);
    } else {
        $itemCode = $organization_code . '001';
    }
    
    if (empty($itemImage['name'])) {
        $errors['itemImage'] = '-Image is required';
    } else {
        $base_dir = "assets/images/";
        $target_dir = $base_dir;
        $target_file = $target_dir . basename($itemImage["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $newFileName = $itemCode . "." . $imageFileType;
        $newFilePath = $target_dir . $newFileName;
        $relativeFilePath = $base_dir . $newFileName;
        
        // Check if file already exists
        if (file_exists($newFilePath)) {
            $errors['itemImage'] = '-File already exists';
        }
        
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
        
        $sql = "INSERT INTO items(id, user_id, organization_id, image_name, name, category_id, stock, price) VALUES ('$itemCode','$_SESSION[user_id]', '$organization_id', '$itemImage', '$item_name', '$itemCategory','$itemStock','$itemPrice')";
        mysqli_query($conn, $sql);
        $sql = "INSERT INTO logs (type, userID, details) VALUES('inventory', '$_SESSION[user_id]', 'User $_SESSION[user_id] - $user_name added an item: $itemCode - $item_name. Stock: $itemStock - Price: P $itemPrice')";
        mysqli_query($conn, $sql);
        echo "success";
    }
    
    
    return;
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
                    style="margin-bottom: 10px; margin-top: 10px; text-align: center; font-size: 1.5rem; font-family: Loew-ExtraBold !important; color: var(--card-text-color);">
                    ADD PRODUCT</div>

                <div style="height: 250px;">
                    <label for="inputItemImage" style="display: block; height: 100%; cursor: pointer;">
                        <img src="assets/images/add-image.png"
                            style="object-fit: contain; height: 100%; width: 100%; vertical-align: middle;" alt="hehe"
                            title="Click to change image" id="displayImage">
                        <input type="file" accept="image/*" id="inputItemImage" style="display: none;">
                    </label>
                </div>

                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="text" id="inputitem_name" placeholder="Product Name" required>

                <select class="category-dropdown" style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px; cursor: pointer;"
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
                        <option value="<?php echo htmlspecialchars($category['id']); ?>">
                            <?php echo htmlspecialchars($category['name']); ?></option>
                    <?php }

                    // Output the first category as the last one
                    if ($lastCategory) {
                        ?>
                        <option value="<?php echo htmlspecialchars($lastCategory['id']); ?>">
                            <?php echo htmlspecialchars($lastCategory['name']); ?></option>
                    <?php } ?>
                </select>
                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="number" id="inputItemStock" placeholder="Stock" required>
                
                <input
                    style="margin: 15px 25px; background-color: rgba(0, 0, 0, 0.075); border: none; height: 3rem; border-radius: 1rem; padding: 0 20px;"
                    type="number" id="inputItemPrice" placeholder="Price" required>

                <div style="margin: 15px 25px; display: flex; gap: 15px;">
                    <div style="width: 50%; cursor: pointer;" class="confirm-button cancel"
                        onclick="window.location.href='inventory.php'">CANCEL</div>
                    <button type="submit" style="width: 50%; border: none; cursor: pointer;"
                        class="confirm-button confirm" onclick="checkAddProd(event, 'addProduct.php','')">SAVE</button>
                </div>

                <div style="margin: 15px 25px; border-radius: 1rem; background-color: rgba(0, 0, 0, 0.466); display: none;"
                    class="confirm-button confirm" id="warningText">

                </div>

                </input>

        </form>


    </div>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script type="text/javascript" src="js/addProduct.js" id="rendered-js"></script>

    <script type="text/javascript" src="js/settings.js" id="rendered-js"></script>

</body>

</html>
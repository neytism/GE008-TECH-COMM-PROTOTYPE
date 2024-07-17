<?php
$sql = "SELECT users.*, organizations.* FROM users JOIN organizations ON users.active_organization = organizations.id WHERE users.id = '$_SESSION[user_id]'";

$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    
    $name = $row["name"];
    $organization_name = $row["organization_name"];
    $organization_id = $row["active_organization"];
    $organization_code = $row["code"];
    $use_template = $row["use_template"];
}

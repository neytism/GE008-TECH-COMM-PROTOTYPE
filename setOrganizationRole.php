<?php
function SetRole($conn, $id, $org){
    if($_SESSION['role'] != 'master'){
             
        $sql = "SELECT * FROM user_organizations WHERE user_id = '$id' AND organization_id = '$org' AND status = 'approved'";
        
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['org_role'] = $row["role"];
            }
        } else{
            $sql = "SELECT * FROM user_organizations WHERE user_id = '$id' AND status = 'approved'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $new_active_organization = $row["organization_id"];
                    $sql = "UPDATE users SET active_organization = '$new_active_organization' WHERE id='$id'";
                    mysqli_query($conn, $sql);
                    $_SESSION['org_role'] = $row["role"];
                
                }
            }
            
            
        }

    } else{
        $_SESSION['org_role'] = 'admin';
    }
    
}




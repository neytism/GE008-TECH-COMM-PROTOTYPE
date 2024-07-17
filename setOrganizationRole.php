<?php
function SetRole($conn, $id, $org){
    if($_SESSION['role'] != 'master'){
             
        $sql = "SELECT * FROM user_organizations WHERE user_id = '$id' AND organization_id = '$org'";
        
        $result = $conn->query($sql);
        
        while ($row = $result->fetch_assoc()) {
            
            $_SESSION['org_role'] = $row["role"];
        }
    } else{
        $_SESSION['org_role'] = 'admin';
    }
    
}




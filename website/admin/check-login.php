<?php
define('ACCESS','OPEN');
require 'admin-loader.php';

// Check Aksi Login
if (isset($_POST['username']) && isset($_POST['password'])) {
    
    // pengamanan dari percobaan hacking
    $username = $db->escape_string($_POST['username']);
    $password = $db->escape_string($_POST['password']);
    
    // hasing with md5
    $password = md5($password .md5($password));
    // SQL DATABASE
    $sql = "SELECT 
                username,
                iduser,
                level_user 
            FROM 
                users 
            WHERE 
                (email='$username' OR username='$username') 
            AND 
                password='$password' 
            LIMIT 1";
    $query = $db->query($sql);

    if (!$query) {
        die($db->error);
    }
    if ($query->num_rows == 1) {
        $result = $query->fetch_assoc();
        
        //session register
        $_SESSION['user_login'] = $result['username'];
        $_SESSION['user_ID']    = $result['iduser'];
        $_SESSION['level_user'] = $result['level_user'];

        header('location:'.$domain.'admin/dashboard.php');
    } else {
        header('location:'.$domain.'admin/login.php?error=salah');
    }
} else {
    header('location:'.$domain.'admin/login.php');
}
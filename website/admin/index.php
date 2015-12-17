<?php

// definisi variable constant "ACCESS" untuk hindari akses langsung 
// pada file file tertentu.
define('ACCESS','OPEN');

// file admin-loader.php
if (!file_exists(dirname(__FILE__).'/admin-loader.php')) { die('File admin-loader Tidak ada'); }
    
    // logout function
    if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
        session_destroy();
        header('location:'.$domain.'login.php');
        exit();
    }
    // sisipkan file loader.php
    header('location:dashboard.php');
    exit();
?>
<?php
// hindari akses langsung ke file ini
if (!defined('ACCESS')) {
    die('System Cannot Running');
}
/**
 * Information to Connecting Database
 */
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'website';

// bisa diganti sesuai alamat direktori website atau domainnya
$domain = 'http://localhost/website';

// definisi main direktori
define('ABSPATH', dirname(__FILE__) . '/');
?>
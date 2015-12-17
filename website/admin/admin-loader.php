<?php
// hindari akses langsung ke file ini
if (!defined('ACCESS')) {
    die('System Cannot Running');
}

// memulai session
session_start();

if (!file_exists('./../config.php')) {
    die('File config.php Tidak ada');
}

// menyisipkan file config
require './../config.php';

// menyisipkan file functions.php
require ABSPATH . 'functions.php';

/**
 * Definisi direktori
 */
define('ADMIN', ABSPATH . 'admin/');
define('TPL', ABSPATH . 'template/');

// koneksi ke database dengan mysqli
$db = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// cek koneksi, jika terjadi maka sistem akan dihentikan. 
if ($db->connect_error) {
    die($db->connect_error);
}

global $DB,
       $start,
       $limit,
       $pagesnum;

$DB = $db;
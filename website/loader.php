<?php
// hindari akses langsung ke file ini
if (!defined('ACCESS')) {
    die('System Cannot Running');
}

// memulai session
session_start();

if (!file_exists(dirname(__FILE__).'/config.php')) {
    die('File config.php Tidak ada');
}

// menyisipkan file config
require dirname(__FILE__).'/config.php';

/**
 * Definisi direktori 
 */
define('ADMIN', ABSPATH . 'admin/');
define('TPL', ABSPATH . 'template/');
// koneksi ke database dengan mysqli
$db = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

// cek koneksi, jika terjadi maka sistem akan dihentikan. 
if ($db->connect_error) {
    die($db->connect_error);
}

/**
 * Management Template
 * @var [$_GET]
 */
$post = (isset($_GET['p'])) ? $_GET['p'] : false;
$cat  = (isset($_GET['cat'])) ? $_GET['cat'] : false;

if (is_int($post) && $post) { // untuk membaca artikel
    require TPL . 'posts.php';

} else if (is_int($cat) && $cat) { // menampilakan list categori
    require TPL . 'categories.php'; 

} else { // menampilkan halaman depan
    require TPL . 'index.php';
}
?>
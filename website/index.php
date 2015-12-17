<?php

// definisi variable constant "ACCESS" untuk hindari akses langsung 
// pada file file tertentu.
define('ACCESS','OPEN');

// file loader.php
if (!file_exists(dirname(__FILE__).'/loader.php')) { die('File Loader Tidak ada'); }
    // sisipkan file loader.php
    include dirname(__FILE__) . '/loader.php';
?>
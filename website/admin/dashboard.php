<?php
require 'header.php'; ?>

<div class="row header">
    <div class="col-md-2 title-site "><h2>ONPanel</h2></div>
    <div class="col-md-8 title-page"><h2>Halaman Dashboard</h2></div>
    <div class="col-md-2 text-right author-shortcut">hi, <?=$_SESSION['user_login'];?></div>
</div>

<div class="row">
<?php require 'sidebar.php';?>
</div>
<?php require 'footer.php';?>
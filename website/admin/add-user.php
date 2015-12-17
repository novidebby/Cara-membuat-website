<?php
require 'header.php';
// DEFAULT VALUE 
$page_title = 'Tambah';
$first_name = '';
$last_name  = '';
$username   = '';
$password   = '';
$email      = '';
$jabatan    = '';
$update = '<input type="hidden" name="add-user"/>';
$button = 'Simpan';

$report = '';

/** 
 * Fungsi Insert
 */
if (isset($_POST['add-user'])) {

    $first_name  = $db->escape_string($_POST['first-name']);
    $last_name   = $db->escape_string($_POST['last-name']);
    $username    = $db->escape_string($_POST['username']);
    $password    = $db->escape_string($_POST['password']);
    $re_password = $db->escape_string($_POST['re-password']);
    $email       = $db->escape_string($_POST['email']);
    $jabatan     = $db->escape_string($_POST['jabatan']);

    // check kesamaan password yang di inputkan
    if ($password != $re_password) {
        $report = 'Password tidak Sama';
    } else {
        $password = md5($password);
        $sql = "INSERT INTO users (username,
                                   password,
                                   email, 
                                   first_name,
                                   last_name,
                                   level_user
                                   ) 
                VALUES ('$username',
                    '$password',
                    '$email',
                    '$first_name',
                    '$last_name',
                    '$jabatan'
                    )";

        if ($db->query($sql)) {
            $id = $db->insert_id;
            header('location:'.$domain.'admin/add-user.php?edit='.$id);
            exit();
        }
    }
}

/**
 * Fungsi Edit
 */
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $sql = "SELECT * FROM users WHERE iduser='{$id}'";
    
    $check = $db->query($sql);

    // check apakah ID yang diperoleh memiliki category ?
    if ($check->num_rows > 0) {
        // jika punya
        $user_data = $check->fetch_assoc();
    } else {
        // jika tidak
        header('location:'.$domain.'admin/users.php');
        exit();
    }

    // change with value from database
    $page_title = 'Edit';
    $first_name = $user_data['first_name'];
    $last_name  = $user_data['last_name'];
    $username   = $user_data['username'];
    $password   = $user_data['password'];
    $email      = $user_data['email'];
    $jabatan    = $user_data['level_user'];
    $update = '<input type="hidden" name="user-update" value="'.$id.'"/>';
    $button = 'Update';
}

/**
 * Fungsi Update
 */
if (isset($_POST['user-update'])) {
    $iduser  = $db->escape_string($_POST['user-update']);
    $first_name  = $db->escape_string($_POST['first-name']);
    $last_name   = $db->escape_string($_POST['last-name']);
    $username    = $db->escape_string($_POST['username']);
    $password    = $db->escape_string($_POST['password']);
    $re_password = $db->escape_string($_POST['re-password']);
    $old_password = $db->escape_string($_POST['old-password']);
    $email       = $db->escape_string($_POST['email']);
    $jabatan     = $db->escape_string($_POST['jabatan']);

    if (!empty($password)) {
        if ($password == $re_password) {
            $password = md5($password);
        }
    } else {
        $password = $old_password;
    }

    $sql = "UPDATE users SET first_name='{$first_name}',
                             last_name='{$last_name}', 
                             username='{$username}', 
                             password='{$password}', 
                             email='{$email}', 
                             jabatan='{$jabatan}' 
                        WHERE iduser={$iduser}";
    if ($db->query($sql)) {
        header('location:'.$domain.'admin/add-user.php?edit='.$iduser);
        exit();
    }
}

/**
 * Fungsi Delete
 */
if (isset($_GET['delete']) &&
    !empty($_GET['delete']) &&
    is_numeric($_GET['delete'])
    ) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE iduser='{$id}'";
    $db->query($sql);
    header('location:'. $domain . 'admin/users.php');
    exit();

}

?>
<div class="row header">
    <div class="col-md-2 title-site"><h2>ONPanel</h2></div>
    <div class="col-md-8 title-page"><h2><?=$page_title;?> User</h2></div>
    <div class="col-md-2 text-right author-shortcut">hi, <?=$_SESSION['user_login'];?></div>
</div>

<div class="row">
    <?php require 'sidebar.php';?>
    <div class="col-md-6">
        <a href="<?=$domain;?>admin/users.php" class="btn btn-danger btn-sm"><em class="glyphicon glyphicon-chevron-left"></em> Users</a>
        <br>
        <br>
        <!-- list user -->
        <form action="" method="post">
            <?=$update;?>
            <div class="form-group">
                <lable>First Name</lable>
                <input type="text" name="first-name" class="form-control" value="<?=$first_name;?>" />
            </div>
            <div class="form-group">
                <lable>Last Name</lable>
                <input type="text" name="last-name" class="form-control" value="<?=$last_name;?>" />
            </div>
            <div class="form-group">
                <lable>Username</lable>
                <input type="text" name="username" class="form-control" value="<?=$username;?>" />
            </div>
            <div class="form-group">
                <lable>Password</lable>
                <input type="password" name="password" class="form-control" />
            </div>
            <div class="form-group">
                <lable>Re-Password</lable>
                <input type="password" name="re-password" class="form-control" />
                <?php
                if (!empty(trim($password))) {?>
                <input type="hidden" name="old-password" value="<?=$password;?>" />
                <?php
                } ?>
            </div>
            <div class="form-group">
                <lable>Email</lable>
                <input type="text" name="email" class="form-control" value="<?=$email;?>" />
            </div>
            <div class="form-group">
                <lable>Jabatan</lable>
                <select name="jabatan" class="form-control">
                    <option value="" >Pilih Jabatan</option>
                    <option value="admin" <?php echo ($jabatan == 'admin') ? 'checked' : '';?> >Administrator</option>
                    <option value="penulis" <?php echo ($jabatan == 'penulis') ? 'checked' : '';?>>Penulis</option>
                </select>
            </div>
            <button class="btn btn-primary"><?=$button;?></button>
        </form>
    </div>
</div>
<?php require 'footer.php';?>
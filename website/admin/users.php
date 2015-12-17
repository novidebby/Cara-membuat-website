<?php
require 'header.php'; ?>
<div class="row header">
    <div class="col-md-2 title-site "><h2>ONPanel</h2></div>
    <div class="col-md-8 title-page"><h2>Halaman Users</h2></div>
    <div class="col-md-2 text-right author-shortcut">hi, <?=$_SESSION['user_login'];?></div>
</div>

<div class="row">
    <?php require 'sidebar.php';?>
    <div class="col-md-10">
        <div class="button">
            <a href="<?=$domain;?>admin/add-user.php" class="btn btn-sm btn-danger">Add User</a>
            <br>
            <br>
        </div>
        <!-- list user -->
        <table class="table">
            <tr>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Option</th>
            </tr>
            <?php
            /**
             * Display All Users
             */
            // prepare pagination 
            pagination('users', 10, 'pages');

            global $start, $limit;
            $sql = "SELECT * FROM users ORDER BY iduser LIMIT {$start}, {$limit}";
            $users = $db->query($sql);

            // check table have value or not
            if ($users->num_rows > 0) {
                while ($user = $users->fetch_assoc()) { ?>
                    <tr>
                        <td><?=$user['first_name'];?> <?=$user['last_name'];?></td>
                        <td><?=$user['username'];?></td>
                        <td><?=$user['email'];?></td>
                        <td><?=$user['level_user'];?></td>
                        <td>
                          <a href="<?=$domain. 'admin/add-user.php?edit=' .$user['iduser'];?>">Edit</a>
                          &nbsp;|&nbsp;
                          <a href="<?=$domain. 'admin/add-user.php?delete=' .$user['iduser'];?>">Delete</a></td>
                    </tr>

                    <?php
                }// end while

            } else { ?>
                <tr>
                    <td colspan="5">No Data</td>
                </tr>
            <?php
            } // end if
            ?>
        </table>
    </div>
</div>
<?php require 'footer.php';?>
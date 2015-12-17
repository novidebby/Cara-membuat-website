<?php
require 'header.php'; 
// Delete Commnets
/**
 * Fungsi untuk menghapus Comments dari Database
 * menggunakan 3 handling untuk menghindari hilangnya
 * semua data
 */
if (isset($_GET['delete']) &&
    !empty($_GET['delete']) &&
    is_numeric($_GET['delete'])
    ) {

    $idcomment = $db->escape_string($_GET['delete']);
    $sql = "DELETE FROM comments WHERE idcomment='{$idcomment}'";
    if ($db->query($sql)) {
        header('location:'.$domain.'comments.php?delete=true');
        exit();
    } else {
        dir('terjadi Error Priksa : '. $db->error);
    }

}
?>

<div class="row header">
    <div class="col-md-2 title-site "><h2>ONPanel</h2></div>
    <div class="col-md-8 title-page"><h2>Halaman Comments</h2></div>
    <div class="col-md-2 text-right author-shortcut">hi, <?=$_SESSION['user_login'];?></div>
</div>

<div class="row">
<?php require 'sidebar.php';?>
<div class="col-md-10">
    <table class="table">
        <tr>
            <th>Form</th>
            <th>Comments</th>
            <th>Response</th>
        </tr>
        <?php 
            // prepare pagination
            // 10 adalah jumlah yang ditampilkan
            // pages adalah parameter GET
            pagination('comments', 10, 'pages');?>
        <?php
        global $start, $limit;

        $sql = "SELECT C.*, P.title FROM 
                        comments C, posting P
   
                    ORDER BY 
                        C.idcomment 
                    DESC LIMIT {$start}, {$limit}";

        $res = $db->query($sql);

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                echo "<tr>";
                echo "<td>
                        <span class='author'>{$row['author']}</span><br/>
                        <span class='email'>{$row['email']}</span><br/>
                        <span class='url'>{$row['url']}</span>
                      </td>";
                echo "<td>
                      <span class='comments'>{$row['comment']}</span>
                      <div class='manage'>
                        <span class='delete'>
                            <a href='{$domain}comments.php?delete={$row['idcomment']}'>Delete</a>
                        </span>&nbsp;&nbsp;
                        <span class='reply'>
                           <a href={$domain}?p={$row['id_post']}' target='_blank'>Reply</a>
                        </span>&nbsp;&nbsp;
                      </div>
                      </td>";
                echo "<td>
                        <a href='{$domain}?p={$row['id_post']}' target='_blank'>{$row['title']}</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'><i>Belum Ada Komentar</i></td></tr>";
        }
        ?>
    </table>
    <?php 
        // display pagings
        pagination_num();?>
</div>
</div>
<?php require 'footer.php';?>
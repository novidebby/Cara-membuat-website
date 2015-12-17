<?php
require 'header.php';

// laporan pengisian kategori berhasikah? gagalkah?
$report = '';

// value Default
$categoryname = '';
$button = 'Submit';
$update = '<input type="hidden" name="category-add" value="true"/>';

// untuk eksekusi penyimpanan kategori
if (isset($_POST['category-add'])) {
    /**
     * @var [$db] adalah inisiasi database
     * @see admin-loader.php
     */
    // escape perlindungan dari sql injection
    $category = $db->escape_string($_POST['category']);

    /**
     * Menghindari kesamaan penamaan kategori
     */
    // command SQL untuk mengecheck
    $sql = "SELECT category FROM categories WHERE category = '$category'";
    $check = $db->query($sql);

    // jika tidak ada yang sama
    if ($check->num_rows == 0) {
        // SQL untuk insert data kedatabase
        $sqlinsert = "INSERT INTO categories (category) VALUES ('$category')";

        // jika berhasil diinputkan
        if ($db->query($sqlinsert)) {
            header('location:'.$domain.'admin/categories.php?insert=true');
            exit();
        } else {
            // jika gagal
            $report = 'terjadi error : '.$db->error;
        }
    } else {
        // jika categori sudah dibuat
        $report = 'Nama Category sudah ada';
    }
}

/**
 * Eksekusi edit
 * Eksekusi akan berjalan apa bila ada parameter GET ../categories.php?edit=ID
 * diaddress bar
 */
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];

    $sql = "SELECT category FROM categories WHERE idcat='$id' LIMIT 1";
    $check = $db->query($sql);

    // check apakah ID yang diperoleh memiliki category ?
    if ($check->num_rows > 0) {
        // jika punya
        $category = $check->fetch_assoc();
    } else {
        // jika tidak
        header('location:'.$domain.'admin/categories.php');
        exit();
    }

    $categoryname = $category['category'];
    $button = 'Update';
    $update = '<input type="hidden" name="update" value="true"/>';
}
/**
 * Eksekusi Update
 * EKsekusi akan berjalan apa bila ada parameter POST pada saat edit
 */
if (isset($_POST['update'])) {
    $idupdate = $db->escape_string($_GET['edit']);
    $catupdate = $db->escape_string($_POST['category']);

    // check apabila penamaan category sudah dipakai
    $sql = "SELECT * FROM 
                categories 
            WHERE 
                category='$catupdate' 
            AND 
                idcat!='$idupdate' ";
    $checking = $db->query($sql);
    // jika belum ada
    if ($checking->num_rows == 0) {
        $sqlupdate = "UPDATE 
                        categories 
                      SET 
                        category='$catupdate' 
                      WHERE 
                        idcat='$idupdate'";
        // check eksekusi
        if ($db->query($sqlupdate)) {
            $report = 'Berhasil Diupdate';
        } else {
            $report = 'Terjadi Kesalahan pada : '.$db->error;
        }
    } else {
        $report = 'Nama Kategori sudah dipakai';
    }
}

/**
 * Eksekusi Delete
 * pada eksekusi ini sedikit rawan apabila parameter (GET) ../categories.php?delete=ID
 * delete bernilai kosong maka
 * semua data pada table categories akan terhapus
 * maka dari itu ada 3 penge-check-an
 * 1. [isset()] ada atau tidak parameter $_GET
 * 2. [empty] bernilai atau tidak
 * 3. [is_numeric] angka atau bukan
 */
if (isset($_GET['delete'])  &&
    !empty($_GET['delete']) &&
    is_numeric($_GET['delete'])
    ) {
    $id = $_GET['delete'];

    $sql = "DELETE FROM categories WHERE idcat='$id'";
    if ($db->query($sql)) {
        header('location:'.$domain.'admin/categories.php');
        exit();
    }
}
?>
<div class="row header">
    <div class="col-md-2 title-site "><h2>ONPanel</h2></div>
    <div class="col-md-8 title-page"><h2>Halaman Categories</h2></div>
    <div class="col-md-2 text-right author-shortcut">hi, <?=$_SESSION['user_login'];?></div>
</div>
<div class="row">
    <?php require 'sidebar.php';?>
    <div class="col-md-5">
        <form method="post">
            <?php
            /**
             * Cetak hasil $report, default nilai var $result adalah kosong
             */
            ?>
            <?=$report;?>
            
            <?php 
            // Laporan berhasil Insert
            echo isset($_GET['insert']) && $_GET['insert']=='true' ? 'Sukses':'';?>
            <?php
            /**
             * @var $update adalah input hidden yang akan bernilai saat berada pada mode EDIT
             * default kosong
             * -
             * @var $categoryname akan bernilai saat mode EDIT
             * defaul kosong
             */
            ?>
            <?=$update;?>
            <div class="form-group">
                <label for="">Category</label>
                <input type="text" 
                       class="form-control" 
                       name="category" 
                       value="<?=$categoryname;?>" 
                       placeholder="Category" />
            </div>
            <?php
            /**
             * @var $button akan berubah jadi update saat MODE Edit,
             * dan akan berubah menjadi Submit ketika MODE tambah 
             */
            ?>
            <button class="btn btn-sm btn-primary" name="submit-category"><?=$button;?></button>
        </form>
    </div>
    <div class="col-md-5">
        <h3 class="title-widget">Categori Lists</h3>
        <table class="table">
            <tr>
                <th>Categories</th>
                <th>Opsi</th>
            </tr>
            <?php 
            //
            // prepare pagination
            pagination('categories', 10, 'pages');?>
            <?php
            global $start, $limit;
            /**
             * Menampilkan Semua Kategori yang sudah disimpan
             */
            $sql = "SELECT * FROM categories ORDER BY category ASC LIMIT {$start}, {$limit}";
            $cats = $db->query($sql);
            
            // jika ada kategori
            if ($cats->num_rows > 0) {
                while ($cat = $cats->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>'.$cat['category'].'</td>';
                    echo '<td><a href="'.$domain.'admin/categories.php?delete='.$cat['idcat'].'">Delete</a> | <a href="'.$domain.'admin/categories.php?edit='.$cat['idcat'].'">Edit</a></td>';
                    echo '</tr>';
                }
            } else {
                // jika tidak ada kategori
                echo "<tr><td colspan='2'>Categori Belum ada</td></tr>";
            }
            ?>
        </table>
        <?php 
        // display pagings
        pagination_num();?>
    </div>
</div>
<?php require 'footer.php';?>
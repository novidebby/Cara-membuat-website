<?php
/**
 * Kumpulan Fungsi 
 */

$domain = trim($domain, '/') . '/';

/**
 * is_login() untuk mengecheck apakah user sudah login atau belum
 * @return boolean [true | false]
 */
function is_login()
{
    if (isset($_SESSION['user_login'])) {
        return true;
    }

    return false;
}

/**
 * [is_admin Check Apakah Admin Tau Bukan]
 * @return boolean [true | false]
 */
function is_admin()
{
    if (isset($_SESSION['level_user']) &&
        $_SESSION['level_user'] == 'admin'
        ) {
        return true;
    }

    return false;
}

/**
 * ini adalah fungsi untuk persiapan membuat pagination
 * @param $table di isi nama table yang akan di paginationkan
 * @param $limit adalah batas untuk berapa banyak data yang ditampilkan
 * @param $param adalah parameter GET 
 * cara menggunakan <?php pagination('namatable', 15, 'page');?>
 */
function pagination($table = null, $limit = 30, $param = 'no')
{
    global $DB, $pagesnum;
    
    if (!isset($_GET[$param]) || empty($_GET[$param])) {
        $start = 0;
        $page  = 1;
    } else {
        $start = ($_GET[$param] - 1) * $limit;
        $page  = $_GET[$param];
    }
    
    // membuat databaru / registrasi global variable
    $GLOBALS['start'] = $start;
    $GLOBALS['limit'] = $limit;

    $result = $DB->query("SELECT * FROM {$table}");
    if (!$result) {
        return false;
    }

    $num = $result->num_rows;

    $pages = ceil($num/$limit);
    
    $pagination = '<nav class="text-right"><ul class="pagination">';
    // jika terdapat halaman maka navigasi akan ditampilkan
    if ($pages > 1) {
        // prev
        if ($page > 1) {
            $pagination .= '<li><a href="?'.$param.'='.($page-1).'" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span></a></li>';
        }
        $pagination .= '<li><a>Page '.$page.' of '.$pages.'</a></li>';
        //next
        if ($page < $pages) {
            $pagination .= '<li><a href="?'.$param.'='.($page+1).'" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span></a></li>';
        }

    }
    $pagination .= '</ul></nav>';
    $pagesnum = $pagination;
}

/**
 * untuk menampikan navigasi pagination
 */
function pagination_num()
{
    global $pagesnum;
    echo $pagesnum;
}

?>
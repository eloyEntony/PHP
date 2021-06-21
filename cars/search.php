<?php
require_once "../connection_database.php";
include "pagination.php";

$car_array = [];
$per_page_html = '';

if (isset($_REQUEST["search"])) {
    $if_search = true;
    $search_keyword = '';
    if (!empty($_POST['search']['keyword'])) {
        $search_keyword = $_POST['search']['keyword'];
    }
    $sql = 'SELECT  c.id, c.name, c.capacity, f.name as fuel FROM cars as c, fuels as f WHERE c.name LIKE :keyword GROUP BY c.name';


    /* Pagination Code starts */
    $page = 1;
    $start = 0;
    if (!empty($_POST["page"])) {
        $page = $_POST["page"];
        $start = ($page - 1) * $show_items;
    }
    $limit = " limit " . $start . "," . $show_items;
    $pagination_statement = $dbh->prepare($sql);
    $pagination_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
    $pagination_statement->execute();


    $count_pages = $pagination_statement->rowCount();

    if (!empty($count_pages)) {
        $per_page_html .= "<ul class='pagination'>";
        $count_pages = ceil($count_pages / $show_items);
        if ($count_pages > 1) {
            for ($i = 1; $i <= $count_pages; $i++) {
                if ($i == $page) {
                    // $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page current" />';
                    $per_page_html .= "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
                } else {
                    // $per_page_html .= '<input type="submit" name="page" value="' . $i . '" class="btn-page" />';
                    $per_page_html .= "<li class='page-item'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
                }
            }
        }
        $per_page_html .= "</ul>";
    }

    $query = $sql . $limit;


    $pdo_statement = $dbh->prepare($query);
    $pdo_statement->bindValue(':keyword', '%' . $search_keyword . '%', PDO::PARAM_STR);
    $pdo_statement->execute();
    $res = $pdo_statement->fetchAll();

    foreach ($res as $item)
        array_push($car_array, $item);
}

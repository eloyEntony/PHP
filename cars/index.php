<?php require_once "../connection_database.php"; ?>

<?php include "../_head.php";

$if_search = false;

//include "search.php";
include "pagination.php";

// $count = "SELECT count(*) as count FROM cars";

// $command = $dbh->prepare($count);
// $command->execute();
// $row = $command->fetch(PDO::FETCH_ASSOC);
// $count_items = $row["count"];
// $show_items = 3;
// $page = 1;
// $count_pages = ceil($count_items / $show_items);

// if (isset($_GET["page"]))
//     $page = $_GET["page"];
?>

<div class="container">

    <form method="POST" class="form-inline my-2 my-lg-0 " style="display: flex; justify-content: center;">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search[keyword]" value="<?php echo $search_keyword; ?>">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>


    <?php
    // if (!empty($car_array)) {
    //     foreach ($car_array as $item) {
    //         echo $item["name"] . "</br>";
    //     }
    // } else
    //     echo "<p>No matches found</p>";
    ?>

    <h1>Cars</h1>
    <a class="btn btn-primary" href="addcar.php">Add new car</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Назва авто</th>
                <th>Об'єм двигуна</th>
                <th>Тип пального</th>
            </tr>
        </thead>

        <?php

        if ($if_search) {
            if (!empty($car_array)) {
                foreach ($car_array as $item) {
                    echo " <tr>
                                    <td>{$item["name"]}</td>
                                    <td>{$item["capacity"]}</td>
                                    <td>{$item["fuel"]}</td>
                                </tr>
                                ";
                }
            } else
                echo "<p>No matches found</p>";
        } else {

            $sql = "SELECT c.id, c.name,c.capacity, f.name as fuel "
                . " FROM cars as c, fuels as f "
                . " WHERE c.fuel_id=f.id"
                . " LIMIT " . ($page - 1) * $show_items . ", " . $show_items;

            $command = $dbh->prepare($sql);
            $command->execute();

            while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                echo "
                    <tr>
                        <td>{$row["name"]}</td>
                        <td>{$row["capacity"]}</td>
                        <td>{$row["fuel"]}</td>
                    </tr>
                    ";
            }
        }
        ?>

    </table>

    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <?php
            $show_begin = 2;
            $right_items = 3;

            for ($i = 1; $i <= $count_pages; $i++) {
                // $active = "";

                // if ($i == $page)
                //     $active = "active";

                // if ($page <= 5 and $i <= $show_begin)
                //     echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";

                // if ($page > 5 && $page < 9 && $i <= ($right_items + $page))
                //     echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";

                // if ($page >= 5) {
                //     if($i<=3) 
                //         echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";                    
                //     else if($i==4) 
                //         echo "<li class='page-item'><a class='page-link' href='?page={$i}'>...</a></li>";                    
                //     else if(($page-4)<=$i && $i<=($page+5))
                //         echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";

                // }

                //echo "<li class='page-item {$active}'><a class='page-link' href='?page={$i}'>{$i}</a></li>";
                echo "<li class='page-item'><a class='page-link' href='?page={$i}'>$i</a></li>";
            }
            $i--;
            //echo "<li class='page-item'><a class='page-link' href='?page={$i}'>...</a></li>";
            //echo "<li class='page-item'><a class='page-link' href='?page={$i}'>$i</a></li>";
            ?>
        </ul>
    </nav>

    <?php
    //echo $per_page_html; 
    ?>
</div>



<?php include "../_footer.php"; ?>
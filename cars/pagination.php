<?php

$count = "SELECT count(*) as count FROM cars";

$command = $dbh->prepare($count);
$command->execute();
$row = $command->fetch(PDO::FETCH_ASSOC);
$count_items = $row["count"];
$show_items = 3;
$page = 1;
$count_pages = ceil($count_items / $show_items);


if (isset($_GET["page"]))
    $page = $_GET["page"];

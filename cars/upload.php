<?php require_once "../guidv4.php" ?>
<?php require_once "../connection_database.php"; ?>

<?php

$name = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $target_dir = "../uploads/";
    $ext = pathinfo(basename($_FILES["images"]["name"]), PATHINFO_EXTENSION);
    $target_file = $target_dir . guidv4() . "." . $ext;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $idcar = 1;

    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
        $stmt = $dbh->prepare("INSERT INTO cars_images (id, name, car_id) VALUES (NULL, :name, :car_id);");
        $stmt->bindParam(':name', $target_file);
        $stmt->bindParam(':car_id', $idcar);
        $stmt->execute();
    }

    //echo $target_file;
    echo " <div class='col-md-2' style='margin-left: -16px;'>
        <div class='card' style='width: 100%; height: 100%;'>
            <div class='card-body' style='padding:0.25rem'>
                <img name='load_image' id='load_image' src='{$target_file}' style='width:100%;  height: 100%; cursor: pointer'>
            </div>
        </div>
    </div>";
}

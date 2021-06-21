<?php require_once "../connection_database.php"; ?>
<?php include "../_head.php"; ?>
<?php include "../upload.php"; ?>


<?php

$name = "";
$capacity = "";
$fuel_id = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {



    // if (!empty($_POST['fuel'])) {
    //     $selected = $_POST['fuel'];
    //     $fuel_id = $selected;
    //     echo 'You have chosen: ' . $fuel_id;
    // } else echo 'Please select the value.';



    // $stmt = $dbh->prepare("INSERT INTO cars (id, name, capacity, fuel_id ) VALUES (NULL, :name, :capacity, :fuel_id);");
    // $stmt->bindParam(':name', $_POST['name']);
    // $stmt->bindParam(':capacity', $_POST['capacity']);
    // $stmt->bindParam(':fuel_id', $fuel_id);
    // $stmt->execute();

    // header("Location: ../cars/index.php");
    // exit;
}

?>



<div class="container">
    <div class="p-3">
        <h2>Add new car</h2>
        <form name="addCarForm" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Car: </label>
                <?php echo "<input type='text' name='name' class='form-control'placeholder='Enter car name' value={$name}>" ?>
                <small class='text-danger' id="name_error" hidden>Name is required!</small>
                <?php if (isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>" ?>
            </div>

            <div class="form-group">
                <label>Capacity: </label>
                <?php echo "<input type='number' name='capacity' class='form-control' placeholder='Enter capacity' value={$capacity}>" ?>
                <small class='text-danger' id="name_error" hidden>Capacity is required!</small>
                <?php if (isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>" ?>
            </div>

            <div class="form-group">
                <label>Select fuel:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" name="fuel">
                        <?php
                        $sql = "SELECT id, name FROM fuels";
                        $command = $dbh->prepare($sql);
                        $command->execute();
                        while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row["id"]}'>{$row["name"]}</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="container">
                    <div class="row" id="foto_row">
                        <div class="col-md-2" style="margin-left: -16px;">
                            <div class="card" style="width: 100%;">
                                <div class="card-body">
                                    <img src="../images/unnamed.png" style="width:100%; cursor: pointer" id="uploadFoto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>

        <form id="formUpload" enctype="multipart/form-data"></form>


    </div>
</div>


<?php include "../_footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


<script>
    $(function() {
        var $uploadFoto = $("#uploadFoto");

        $uploadFoto.on("click", function() {
            var uploader;
            if (uploader) uploader.remove();

            uploader = $("<input class='form-control d-none' type='file' name='images' id='images'>");
            $("#formUpload").html(uploader);

            uploader.click();

            uploader.on("change", function() {
                $("#formUpload").trigger('submit');
                //alert("fff")
            })

        });


        $("form#formUpload").submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "/cars/upload.php",
                type: 'POST',
                data: formData,
                //dataType: 'json',
                success: function(data) {
                    console.log(data);

                    $("#foto_row").append(data);
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });


    });
</script>
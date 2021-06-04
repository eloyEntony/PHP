<?php require_once "connection_database.php"; ?>
<?php require_once "guidv4.php" ?>
<?php
$name = "";
$image_url = "";
$image = "";
$file_loading_error = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $name = $_POST['name'];
    $errors = [];
    if (empty($name)) {
        $errors["name"] = "Name is required";
    } else {
        $target_dir = "uploads/";
        $ext = pathinfo(basename($_FILES["fileToUpload"]["name"]), PATHINFO_EXTENSION);
        $target_file = $target_dir . guidv4() . "." . $ext;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                array_push($file_loading_error, "File is not an image.");
                $uploadOk = 0;
            }
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 5000000) {
            array_push($file_loading_error, "Sorry, your file is too large.");
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            array_push($file_loading_error, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            array_push($file_loading_error, "Sorry, your file was not uploaded.");
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $stmt = $dbh->prepare("INSERT INTO animals (id, name, image) VALUES (NULL, :name, :image);");
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':image', $target_file);
                $stmt->execute();
                header("Location: index.php");
                exit;
            } else {
                array_push($file_loading_error, "Sorry, there was an error uploading your file.");
            }
        }
    }
}
?>

<?php include "_head.php"; ?>
<div class="container">
    <div class="p-3">
        <h2>Add new animal</h2>
        <form name="addAnimalForm" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Animal: </label>
                <?php echo "<input type='text' name='name' class='form-control'placeholder='Enter animal name' value={$name}>" ?>
                <small class='text-danger' id="name_error" hidden>Name is required!</small>
                <?php if (isset($errors['name']))
                    echo "<small class='text-danger'>{$errors['name']}</small>" ?>
            </div>
            <div class="form-group">
                <label>Select image to upload:</label>
                <?php echo "<input class='form-control d-none' type='file' name='fileToUpload' id='fileToUpload'>" ?>

                <input type='hidden' name='hideninput' id='hideninput'>
                <img src="..." width="300px" style="cursor: pointer" id="img_upload" />

                <?php foreach ($file_loading_error as &$value) {
                    echo "<small class='text-danger'>$value</small>";
                } ?>

                <?php if (isset($errors['image'])) echo "<small class='text-danger'>{$errors['image']}</small><br>" ?>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit</button>
        </form>
    </div>
</div>


<script type='text/javascript'>
    function preview_image(event) {
        var reader = new FileReader();
        reader.onload = function() {
            var output = document.getElementById('output_image');
            output.src = reader.result;
        }
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<?php include "_footer.php"; ?>
<?php include "cropperModal.php" ?>

<script>
    $(function() {
        var $img_upload = $("#img_upload");
        var $fileToUpload = $("#fileToUpload");
        var $cropperModal = $("#cropperModal");

        var $hiden = $("#hideninput");
        var $btnCroppeImage = $("#btnCroppeImage");
        var $btnRotate = $("#btnRotate");

        const cropper = new Cropper(
            document.getElementById("croppedImage"), {
                aspectRatio: 1 / 1,
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });



        $img_upload.on("click", function() {
            $fileToUpload.click();
        });




        $fileToUpload.on("change", function(e) {
            const [file] = e.target.files;
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    var data = event.target.result;
                    $cropperModal.modal("show");
                    cropper.replace(data);
                }
                reader.readAsDataURL(file);
            }
        });

        $btnCroppeImage.on("click", function() {
            var croppedData = cropper.getCroppedCanvas().toDataURL();
            $img_upload.attr("src", croppedData);
            $cropperModal.modal("hide");
            $hiden.val(croppedData);

            console.log(croppedData);


            //file_put_contents('/uploads/1.jpg', file_get_contents(croppedData));


            //$fileToUpload.val(croppedData);
            //convert base64 to img
            // var image = new Image();
            // image.src = 'data:image/png;base64,' + croppedData;
            //fileToUpload.val(image);

            // canvas = cropper.getCroppedCanvas({
            //     width: 400,
            //     height: 400
            // });

            // canvas.toBlob(function(blob) {
            //     url = URL.createObjectURL(blob);
            //     var reader = new FileReader();
            //     reader.readAsDataURL(blob);
            //     reader.onloadend = function() {
            //         var base64data = reader.result;
            //         $.ajax({
            //             url: 'upload.php',
            //             method: 'POST',
            //             data: {
            //                 image: base64data
            //             },
            //             success: function(data) {
            //                 $modal.modal('hide');
            //                 $('#fileToUpload').attr('src', data);
            //             }
            //         });
            //     };
            // });

        });

        $btnRotate.on("click", function() {
            cropper.rotate(90);
        });

    });
</script>
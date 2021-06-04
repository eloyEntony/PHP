<?php require_once "connection_database.php"; ?>
<?php include "_head.php"; ?>


<form action="uploadingFile.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>


<?php include "_footer.php"; ?>
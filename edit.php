<?php include "_head.php"; ?>
<?php require_once "connection_database.php"; ?>
<?php

$id = null;
if (!empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}

if (null == $id) {
    header("Location: index.php");
}

if (!empty($_POST)) {
    // keep track validation errors
    $nameError = null;
    $imageError = null;

    // keep track post values
    $name = $_POST['name'];
    $image = $_POST['image'];


    // validate input
    $valid = true;
    // check for space
    $name = isset($name) ? trim($name) : false;
    $image = isset($image) ? trim($image) : false;

    if (empty($name)) {
        $nameError = 'Please enter Name';
        $valid = false;
    }

    if (empty($image)) {
        $imageError = 'Please enter image';
        $valid = false;
    }


    //update data
    if ($valid) {
        $sql = "UPDATE animals  set name = ?, image = ? WHERE id = ?";
        $q = $dbh->prepare($sql);
        $q->execute(array($name, $image, $id));
        header("Location: index.php");
    }
} else {
    //get data
    $query = $dbh->prepare("SELECT * FROM animals where id = {$id}");
    $query->execute();
    $data = $query->fetch(PDO::FETCH_ASSOC);
    $name = $data['name'];
    $image = $data['image'];
}
?>

<body>
    <div class="container m-5">
        <div class="row">
            <h3>Update enimal :</h3>
        </div>

        <form method="post">

            <div class="row mb-3  <?php echo !empty($nameError) ? 'error' : ''; ?>">
                <label class="col-sm-2 col-form-label text-right">Name :</label>
                <div class="col-sm-10">
                    <input class="form-control" name="name" type="text" placeholder="Name" value="<?php echo !empty($name) ? $name : ''; ?>">
                    <?php if (!empty($nameError)) : ?>
                        <span class="help-inline"><?php echo $nameError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row mb-3 <?php echo !empty($imageError) ? 'error' : ''; ?>">
                <label class="col-sm-2 col-form-label text-right">Image :</label>
                <div class="col-sm-10">
                    <input class="form-control" name="image" type="text" placeholder="Image" value="<?php echo !empty($image) ? $image : ''; ?>">
                    <?php if (!empty($imageError)) : ?>
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <div>
                <button type="submit" class="btn btn-success">Update</button>
                <a class="btn btn-primary" href="index.php">Back</a>
            </div>
        </form>


    </div>
</body>
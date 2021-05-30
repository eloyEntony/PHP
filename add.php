<?php include  "_head.php"?>
<?php require_once "connection_database.php";?>

<?php
    $error = [];
    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $name = $_POST["name"];
        $image = $_POST["image"];

        if(empty($name))
           array_push($error, "Empty name");
        if(empty($image))
            array_push($error, "Empty image");
        else{
            $sql = "INSERT INTO animals (name, image) VALUES (?, ?)";
            $dbh->prepare($sql)->execute([$_POST["name"], $_POST["image"]]);
            header('Location: /');
            exit;
        }
    }
?>


<div class="container">
    <h1>Add new animal</h1>
    <a href="/index.php" class="btn btn-primary">Back</a>

    <form method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" >
            <?php
                if(in_array("Empty name", $error))
                    echo "<small>Empty name</small>";
            ?>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image URL:</label>
            <input type="text" class="form-control" id="image" name="image" placeholder="Image" >
            <?php
                if(in_array("Empty image", $error))
                    echo "<small>Empty image</small>";
            ?>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>

<?php include "_footer.php"?>


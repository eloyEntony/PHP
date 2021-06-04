<?php require_once "connection_database.php"; ?>
<?php include "_head.php"; ?>

<?php
$stmt = $dbh->prepare("INSERT INTO animals (id, name, image) VALUES (NULL, :name, :image);");
$stmt->bindParam(':name', $_POST['name']);
$stmt->bindParam(':image', $_POST['image']);
$stmt->execute();

header("Location: index.php");
exit;
?>
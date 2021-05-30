<?php include "_head.php"; ?>
<?php require_once "connection_database.php"; ?>

<?php
if (isset($_POST['delete'])) {

    $id = $_POST['id'];
    $query = $dbh->prepare("DELETE FROM animals WHERE id={$id}");
    $query->execute();
}
?>

<body>
    <div class="container">
        <h1>Animal list</h1>
        <a href="/add.php" class="btn btn-success"> Add </a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $command = $dbh->prepare("select id, name, image from animals");
                $command->execute();
                while ($row = $command->fetch(PDO::FETCH_ASSOC)) {
                    $i++;
                    echo "
                <tr>                    
                    <th scope='row'>$i</th>
                    <th scope='row'>{$row["id"]}</th>
                    <td>{$row["name"]}</td>
                    <td>{$row["image"]}</td>
                    <td>
                        <a  class='btn btn-warning' href='/edit.php?id=" . $row["id"] . "'><i class='fa fa-edit'></i></a>
                        

    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#exampleModal'><i class='fa fa-trash'></i></button>
                     </td>
                </tr>
                
                
                <div class='modal fade' id='exampleModal' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                    <div class='modal-dialog'>
                        <div class='modal-content'>
                            <div class='modal-header'>
                                <h5 class='modal-title' id='exampleModalLabel'>Delete animal " . $row["name"] . "</h5>
                                <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                            </div>
                            <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>NO</button>                                
                                <form method='POST'>
                                    <input type=hidden name=id value=" . $row["id"] . " >
                                    <input type=submit class='btn btn-danger' value=Yes name=delete>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>       
                
             ";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include "_footer.php" ?>
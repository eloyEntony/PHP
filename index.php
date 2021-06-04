<?php require_once "connection_database.php"; ?>
<?php include "_head.php"; ?>
<?php include "modal.php"; ?>


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
                    <th scope="col">Photo</th>
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
                    <td><img style='width: 200px; height=200px;' src='{$row["image"]}' class='img-thumbnail' alt='Animal image'></td>
                    <td>
                        <a  class='btn btn-warning' href='/edit.php?id=" . $row["id"] . "'><i class='fa fa-edit'></i></a>                     
                        <button  onclick='loadDeleteModal(${row["id"]}, `${row["name"]}`, `${row["image"]}`)' data-toggle='modal' data-target='#modalDelete' class='btn btn-danger' ><i class='fas fa-trash-alt'></i></button>
                     </td>
                </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


    <script>
        function loadDeleteModal(id, name, image) {
            $(`#modalDeleteContent`).empty();
            $(`#modalDeleteContent`).append(`<div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete animal ${name}?</h5>
            <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fas fa-times"></i></span>
            </button>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <form action="delete.php" method="post">
                <input type='hidden' name='id' value='${id}'>
                <input type='hidden' name='image' value='${image}'>
                <button type="submit" name="delete_submit" class="btn btn-danger">Delete</button>
            </form>
        </div>`);
        }
    </script>

    <?php include "_footer.php" ?>
<?php
    include 'includes/header.php';
    $userId = $_SESSION['userData']['id'];
    $sql = "SELECT (SELECT COUNT(id) FROM todo WHERE user_id='$userId') AS 'all_todos',
                   (SELECT COUNT(id) FROM todo WHERE status=0 AND user_id='$userId') AS 'incomplete_todos', 
                   (SELECT COUNT(id) FROM todo WHERE status=1 AND user_id='$userId') AS 'completed_todos'";

    $result = mysqli_query($db_conn, $sql);

    $data   = mysqli_fetch_assoc($result);
?>

<section>
    <div class="container">
        <div class="row mb-5 mt-3 mx-auto">
            <div class="col-lg-12">
                <?php if(isset($_SESSION['sessionMsg'])){
                    if(isset($_SESSION['sessionMsg']['success'])){
                        ?>
                        <div class="text-center mt-3 alert alert-success alert-dismissible fade show" role="alert">
                            <?=$_SESSION['sessionMsg']['success'];?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php }
                    unset($_SESSION['sessionMsg']); }
                ?>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">All Todos</h5>
                        <hr>
                        <p class="card-text text-center"><?=$data['all_todos'];?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-outline-secondary" href="todo-view.php?by=all">VIEW</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Incomplete Todos</h5>
                        <hr>
                        <p class="card-text text-center"><?=$data['incomplete_todos'];?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-outline-secondary" href="todo-view.php?by=incomplete">VIEW</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-center">Completed Todos</h5>
                        <hr>
                        <p class="card-text text-center"><?=$data['completed_todos'];?></p>
                    </div>
                    <div class="card-footer text-center">
                        <a class="btn btn-outline-secondary" href="todo-view.php?by=completed">VIEW</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include 'includes/footer.php';
?>
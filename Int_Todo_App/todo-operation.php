<?php
    include 'includes/header.php';

    $action = null;
    if(isset($_GET['action'])){
        $action = mysqli_real_escape_string($db_conn, trim($_GET['action']));
    }
?>
<section>
    <div class="container">
        <div class="row mb-3 mt-lg-5 mt-sm-3">
            <?php if($action=='add'){ ?>
                <div class="col-md-8 col-lg-5 col-sm-12 mx-auto">
                    <div class="card mt-lg-5 mt-sm-3">
                        <div class="card-header">
                            <h4 class="card-title">Add Todo</h4>
                        </div>
                        <div class="card-body bg-white">
                            <form method="post" action="todo-operation.php?action=insert">
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" placeholder="Title" name="title" minlength="2" maxlength="250"  required>
                                </div>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="details" placeholder="Details"></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input class="form-control" type="date" name="start_date" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">End Date</label>
                                    <input class="form-control" type="date" name="end_date" required>
                                </div>
                                <div class="form-group mb-2">
                                    <button class="btn btn-primary" type="submit" name="addBtn">
                                        Add
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
             <?php } else if($action=='insert'){
                    $errors = array();
                    if($_SERVER['REQUEST_METHOD']=='POST'){
                        extract($_POST);
                        $title       = mysqli_real_escape_string($db_conn, trim($title));
                        $details     = mysqli_real_escape_string($db_conn, trim($details));
                        $startDate   = mysqli_real_escape_string($db_conn, trim($start_date));
                        $endDate     = mysqli_real_escape_string($db_conn, trim($end_date));
                        $userId      = $_SESSION['userData']['id'];

                        if(empty($title)){
                            array_push($errors, 'Title is empty!');
                        }
                        else if(mb_strlen($title)<2 || mb_strlen($title)>250){
                            array_push($errors, 'Title should not contain less than three chars and more than 250 chars!');
                        }

                        if(empty($start_date)){
                            array_push($errors, 'Start Date is empty!');
                        }

                        if(empty($end_date)){
                            array_push($errors, 'End Date is empty!');
                        }
                        else if(strtotime($endDate)<strtotime($startDate)){
                            array_push($errors, 'End Date should be equal or greater than Start Date!');
                        }

                        if(!empty($details) && mb_strlen($details)>1000){
                            array_push($errors, 'Details should not contain more than 1000 chars!');
                        }

                        if(!empty($errors)){
                            foreach ($errors as $error) { ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?=$error;?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php }
                        }
                        else{
                            $sql = "INSERT INTO todo(title, details, start_date, end_date, user_id) VALUES ('$title', '$details', '$startDate', '$endDate', $userId)";

                            $query = mysqli_query($db_conn, $sql);

                            if($query){
                                $_SESSION['sessionMsg']['success'] = 'Todo Created Successfully!';
                                header('Location: dashboard.php');
                                exit();
                            }
                            else{
                                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.mysqli_error($db_conn).'
                                    </div>';
                                exit();
                            }
                        }
                    }
            }else if($action=='edit'){

                if(isset($_GET['edit_id'])){
                    $editId = mysqli_real_escape_string($db_conn, trim($_GET['edit_id']));
                    $userId = $_SESSION['userData']['id'];
                    $getTodoDataSql = "SELECT * FROM todo WHERE id='$editId' AND user_id='$userId' LIMIT 1";
                    $result         = mysqli_query($db_conn, $getTodoDataSql);
                    $data           = mysqli_fetch_assoc($result);

                    if(is_null($data)){ header('Location: dashboard.php'); exit();}
                }

                ?>
                <div class="col-md-8 col-lg-5 col-sm-12 mx-auto">
                    <div class="card mt-lg-5 mt-sm-3">
                        <div class="card-header">
                            <h4 class="card-title">Update Todo</h4>
                        </div>
                        <div class="card-body bg-white">
                            <form method="post" action="todo-operation.php?action=update">
                                <input type="hidden" name="from" value="<?=$_GET['from'];?>">
                                <?php if($_GET['from']=='search'){ ?>
                                    <input type="hidden" name="search_key" value="<?=$_GET['search_key'];?>">
                                <?php } ?>
                                <div class="form-group mb-3">
                                    <input class="form-control" type="text" placeholder="Title" name="title" minlength="2" maxlength="250"  value="<?=$data['title'];?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <textarea class="form-control" name="details" placeholder="Details"><?=$data['details'];?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input class="form-control" type="date" name="start_date" value="<?=$data['start_date'];?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="form-label">End Date</label>
                                    <input class="form-control" type="date" name="end_date" value="<?=$data['end_date'];?>" required>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" <?php  if($data['status']==1){ echo 'checked'; } ?> value="1" name="todoStatus">
                                        <label class="form-check-label" for="flexSwitchCheckDefault"><?php
                                            if($data['status']==1) { echo 'Completed';} else{ echo 'Incomplete'; }
                                            ?></label>
                                    </div>
                                </div>
                                <input type="hidden" name="updateId" value="<?=$data['id'];?>">
                                <div class="form-group mb-2">
                                    <button class="btn btn-primary" type="submit" name="updateBtn">
                                        Update
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            <?php }else if($action=='update'){
                $errors = array();
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    extract($_POST);
                    $title       = mysqli_real_escape_string($db_conn, trim($title));
                    $details     = mysqli_real_escape_string($db_conn, trim($details));
                    $startDate   = mysqli_real_escape_string($db_conn, trim($start_date));
                    $endDate     = mysqli_real_escape_string($db_conn, trim($end_date));
                    if(!isset($todoStatus)){
                        $todoStatus = 0;
                    }
                    $userId      = $_SESSION['userData']['id'];

                    if(empty($title)){
                        array_push($errors, 'Title is empty!');
                    }
                    else if(mb_strlen($title)<2 || mb_strlen($title)>250){
                        array_push($errors, 'Title should not contain less than three chars and more than 250 chars!');
                    }

                    if(empty($start_date)){
                        array_push($errors, 'Start Date is empty!');
                    }

                    if(empty($end_date)){
                        array_push($errors, 'End Date is empty!');
                    }
                    else if(strtotime($endDate)<strtotime($startDate)){
                        array_push($errors, 'End Date should be equal or greater than Start Date!');
                    }

                    if(!empty($details) && mb_strlen($details)>1000){
                        array_push($errors, 'Details should not contain more than 1000 chars!');
                    }

                    if(!empty($errors)){
                        foreach ($errors as $error) { ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?=$error;?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php }
                    }
                    else{

                        $sql = "UPDATE todo SET title='$title', details='$details', start_date='$startDate', end_date='$endDate', status='$todoStatus' WHERE id='$updateId' AND user_id='$userId' LIMIT 1";

                        $result = mysqli_query($db_conn, $sql);

                        if($result){
                            $_SESSION['sessionMsg']['success'] = 'Todo Updated Successfully!';
                            if($from=='search'){
                                header('Location: search.php?search_key='.$search_key);
                                exit();
                            }
                            header('Location: todo-view.php?by='.$from);
                            exit();

                        }
                        else{
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.mysqli_error($db_conn).'
                                    </div>';
                            exit();
                        }
                    }
                }
            }else if($action=='delete'){
                if(isset($_GET['delete_id'])){
                    $deleteId = mysqli_real_escape_string($db_conn, trim($_GET['delete_id']));
                    $userId   = $_SESSION['userData']['id'];

                    $sql = "DELETE FROM todo WHERE id='$deleteId' AND user_id='$userId' LIMIT 1";
                    $result = mysqli_query($db_conn, $sql);

                    if($result){
                        $_SESSION['sessionMsg']['success'] = 'Todo Deleted Successfully';
                        if($_GET['from']=='search'){
                            header('Location: search.php?search_key='.$_GET['search_key']);
                            exit();
                        }
                        header('Location: todo-view.php?by='.$_GET['from']);
                        exit();
                    }
                    else{
                        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'.mysqli_error($db_conn).'
                                    </div>';
                        exit();
                    }
                }
            } ?>
        </div>
    </div>
</section>

<?php
    include 'includes/footer.php';
?>

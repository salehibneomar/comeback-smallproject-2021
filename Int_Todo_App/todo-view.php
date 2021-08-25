<?php
    include 'includes/header.php';

    if(isset($_GET['by'])){
        $by= array('all'=>'*', 'incomplete'=>0, 'completed'=>1);

        if(array_key_exists($_GET['by'], $by)){
            $by = $by[$_GET['by']];
        }
        else{
            header('Location: todo-view.php?by=all');
            exit();
        }

    }
    else{
        header('Location: dashboard.php');
        exit();
    }
?>

    <section>
        <div class="container">
            <div class="row mb-5 mt-3 mx-auto">
                <div class="col-lg-10 col-md-12 mx-auto mt-5">
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
                    <div class="card">
                        <div class="card-header p-4">
                            <div class="row">
                                <div class="col-lg-9 col-md-8 col-sm-12">
                                    <h5 class="card-title">
                                        <?=ucfirst($_GET['by'])." Todos";?>
                                    </h5>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <form method="get" action="" id="sort-by">
                                        <div class="form-group">
                                            <input type="hidden" value="<?=$_GET['by'];?>" name="by">
                                            <select class="form-select form-select-sm" name="sort">
                                                <option>Default</option>
                                                <?php
                                                   $options = array('ID: ASC'=>'id.asc',
                                                                 'Start Date: ASC'=>'start_date.asc',
                                                                 'Start Date: DESC'=>'start_date.desc',
                                                                 'End Date: ASC'=>'end_date.asc',
                                                                 'End Date: DESC'=>'end_date.desc');
                                                $sort = false;
                                                if(isset($_GET['sort']) && !empty(trim($_GET['sort']))){
                                                    $sort     = mysqli_real_escape_string($db_conn, $_GET['sort']);
                                                    if(!in_array($sort, $options)){
                                                        header('Location: todo-view.php?by='.$_GET['by']);
                                                    }
                                                }

                                                   foreach ($options as $key => $value){
                                                ?>
                                                       <option value="<?=$value;?>" <?php if($value==$sort) echo 'selected'; ?>><?=$key;?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body overflown-table">
                            <?php

                            $userId   = $_SESSION['userData']['id'];
                            $sortBy   = 'id';
                            $sortType ='desc';

                            if($sort){
                                $sort     = explode('.', $sort);
                                $sortBy   = current($sort);
                                $sortType = end($sort);
                            }

                            $sql = "SELECT * FROM todo WHERE user_id='$userId' ORDER BY ".$sortBy." ".$sortType;

                            if(is_int($by)){
                                $sql = "SELECT * FROM todo WHERE user_id='$userId' AND status='$by'
                                               ORDER BY ".$sortBy." ".$sortType;
                            }

                            $dataCount = mysqli_num_rows($db_conn->query($sql));
                            $firstPage    = 1;
                            $rowPerPaging = 5;
                            $totalPaging  = ceil($dataCount/$rowPerPaging);
                            $offset       = 0;
                            $currentPage  = 1;

                            if(isset($_GET['page'])){
                                $currentPage = (int) mysqli_real_escape_string($db_conn, $_GET['page']);
                                if($currentPage<1 || $currentPage>$totalPaging){
                                    header('Location: todo-view.php?by='.$_GET['by']);
                                    exit();
                                }
                                $offset=($currentPage-1) * $rowPerPaging;
                            }

                            $sql.=" LIMIT ".$rowPerPaging." OFFSET ".$offset;
                            $result = mysqli_query($db_conn, $sql);

                            ?>
                            <span class="badge bg-secondary">Total Data Found: <?=$dataCount;?></span>
                            <?php if($dataCount>0){ ?>
                            <table class="mt-2 table table-bordered table-striped">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="2%">ID</th>
                                        <th>Title</th>
                                        <th width="12%">Start</th>
                                        <th width="12%">End</th>
                                        <?php
                                            if($by!=1){
                                        ?>
                                                <th width="10%">Remaining</th>
                                        <?php } ?>
                                        <?php
                                            if($_GET['by']=='all'){ ?>
                                                <th width="10%">Status</th>
                                        <?php }?>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    while($row = mysqli_fetch_assoc($result)){

                                ?>
                                        <tr>
                                            <td><?=$row['id'];?></td>
                                            <td><?=$row['title'];?></td>
                                            <td><?=date('d-M-y',strtotime($row['start_date']));?></td>
                                            <td><?=date('d-M-y',strtotime($row['end_date']));?></td>
                                            <?php
                                                if($by!=1){
                                            ?>
                                            <td>
                                                <?php
                                                    $fromDate  = date_create('now');
                                                    $toDate     = date_create($row['end_date']);
                                                    $remainingDays = date_diff($fromDate, $toDate);

                                                    if($remainingDays->format('%R')=='-'){
                                                        echo 'Time Over';
                                                    }
                                                    else if($remainingDays->format('%a')==0){
                                                        echo 'Deadline';
                                                    }
                                                    else if($remainingDays->format('%a')==1){
                                                        echo '1 Day';
                                                    }
                                                    else{
                                                        echo $remainingDays->format('%a').' Days';
                                                    }
                                                ?>
                                            </td>
                                            <?php }
                                            if($_GET['by']=='all'){ ?>
                                                <td ><?php if($row['status']==1){ echo 'Completed'; }else{ echo 'Incomplete'; }?></td>
                                            <?php }?>
                                            <td>
                                                <div class="btn-group align-center">
                                                    <a href="todo-operation.php?single_id=<?=$row['id'];?>" class="btn btn-sm btn-success">View</a>
                                                    <a href="todo-operation.php?action=edit&edit_id=<?=$row['id'];?>&from=<?=$_GET['by'];?>" class="btn btn-sm btn-info">Edit</a>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#delete_modal_<?=$row['id'];?>" >Delete</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="delete_modal_<?=$row['id'];?>" >
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Are you sure?</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-end">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <a href="todo-operation.php?action=delete&delete_id=<?=$row['id'];?>&from=<?=$_GET['by'];?>" type="button" class="btn btn-danger">Yes</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php } ?>

                            <nav aria-label="d-block Page navigation">
                                <?php
                                    $pagingUrl = "todo-view.php?by=".$_GET['by']."&page=";
                                    if($sort){
                                        $pagingUrl = "todo-view.php?by=".$_GET['by']."&sort=".$_GET['sort']."&page=";
                                    }
                                ?>
                                <ul class="pagination justify-content-end">
                                    <li class="page-item <?php if($currentPage<=1){ echo "disabled"; } ?>">
                                        <a class="page-link" href="<?=$pagingUrl.($currentPage-1);?>">Previous</a>
                                    </li>
                                    <?php for($p=1; $p<=$totalPaging; ++$p){ ?>
                                        <li class="page-item <?php if($p==$currentPage){ echo "active"; } ?>" ><a class="page-link" href="<?=$pagingUrl.$p;?>"><?=$p;?></a></li>
                                    <?php } ?>
                                    <li class="page-item <?php if($currentPage>=$totalPaging){ echo "disabled"; } ?>">
                                        <a class="page-link" href="<?=$pagingUrl.($currentPage+1);?>">Next</a>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
    include 'includes/footer.php';
?>

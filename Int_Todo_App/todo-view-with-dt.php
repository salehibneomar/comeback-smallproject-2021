<?php
    include 'includes/header.php';
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
                                <div class="col-md-12">
                                    <h5 class="card-title">
                                        All Todo with DT
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body overflown-table">

                            <table class="mt-2 table table-bordered table-striped display" id="server-side-dt">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="2%">ID</th>
                                        <th>Title</th>
                                        <th width="12%">Start</th>
                                        <th width="12%">End</th>
                                        <th width="10%">Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
    include 'includes/footer.php';
?>
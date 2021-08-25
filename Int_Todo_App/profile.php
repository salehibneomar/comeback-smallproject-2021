<?php
    include 'includes/header.php';

?>

    <section>
        <div class="container">
            <div class="row mb-5 mt-3 mx-auto">
                <div class="col-md-4 col-sm-12 mt-5 mx-auto">
                    <div class="card">
                        <div class="card-body text-center">
                            <table class="table">
                                <tr>
                                    <td class="fw-bold">Name</td>
                                    <td><?=$_SESSION['userData']['name'];?></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Phone</td>
                                    <td><?=$_SESSION['userData']['phone_number'];?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer text-end">
                            <a href="profile.php?action=edit" class="btn btn-sm btn-danger">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
    include 'includes/footer.php';
?>
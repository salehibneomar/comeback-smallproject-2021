<?php
    include 'includes/header.php';
?>

<section>
    <div class="container">
        <div class="row mb-3 mt-lg-5 mt-sm-3">
            <div class="col-md-8 col-lg-5 col-sm-12 mx-auto">
                <?php
                    $errorMsg = "";
                    if(isset($_POST['loginBtn'])){
                        extract($_POST);
                        $phoneNumber = mysqli_real_escape_string($db_conn, trim($phoneNumber));
                        $pin         = mysqli_real_escape_string($db_conn, trim($pin));

                        if(empty($pin) || empty($phoneNumber)){
                            $errorMsg = "Empty credentials found!";
                        }
                        else{
                            $pin    = SHA1($pin);
                            $sql    = "SELECT * FROM user WHERE phone_number='$phoneNumber' AND pin='$pin' LIMIT 1";
                            $result = mysqli_query($db_conn, $sql);

                            if(mysqli_num_rows($result)==1){
                                $data = mysqli_fetch_assoc($result);
                                $_SESSION['userData'] = $data;

                                header('Location: dashboard.php');
                                exit();
                            }
                            else{
                                $errorMsg = "Invalid credentials";
                            }
                        }

                    }
                ?>
                <?php if($errorMsg){ ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?=$errorMsg;?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <div class="card mt-lg-5 mt-sm-3">
                    <div class="card-header">
                        <h4 class="card-title">Login Panel</h4>
                    </div>
                    <div class="card-body bg-white">
                        <form method="post" action="">
                            <div class="form-group mb-3">
                                <input class="form-control" type="tel" placeholder="Phone Number" name="phoneNumber" minlength="11" maxlength="12">
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control" type="password" placeholder="PIN" pattern="[0-9]+" minlength="6" maxlength="6" name="pin">
                            </div>
                            <div class="form-group mb-2">
                                <button class="btn btn-primary" type="submit" name="loginBtn">
                                    Login
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    include 'includes/footer.php';
?>


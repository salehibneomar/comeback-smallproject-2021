<?php
    require 'config/db.php';
    date_default_timezone_set('Asia/Dhaka');
    ob_start();
    session_cache_limiter(0);
    session_start();

    $scriptName = basename($_SERVER['PHP_SELF'], '.php');

    $pageTitle  = ucwords(is_int(strpos($scriptName,'-'))?
                                str_replace('-', ' ', $scriptName) : $scriptName);

    $pageTitle = ($pageTitle=='Index' || empty($pageTitle)) ? 'Login' : $pageTitle;

    if((!isset($_SESSION['userData']) || empty($_SESSION['userData'])) && (($pageTitle!='Login' && !empty($pageTitle)))){
        header('Location: index.php');
        exit();
    }

    if(($pageTitle=='Login' || empty($pageTitle)) && (isset($_SESSION['userData']) && !empty($_SESSION['userData']))){
        header('Location: dashboard.php');
        exit();
    }

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">

    <style>
        body{
            font-family: 'Lato', sans-serif;
        }
        .overflown-table{
            overflow-x: auto !important;
        }
    </style>

    <title><?=$pageTitle;?></title>
</head>
<body class="bg-secondary">

<?php
    if($pageTitle!='Login' && !empty($pageTitle) && isset($_SESSION['userData'])){ ?>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <span class="navbar-brand fw-bold">TodoApp</span>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">Home</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="todo-operation.php?action=add">Add Work</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="profile.php?action=view">Profile</a>
                            </li>

                            <li class="nav-item">
                                <form class="d-flex" method="get" action="search.php">
                                    <input class="ms-lg-4 form-control me-2" type="search" placeholder="Type Title..." name="search_key" required>
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </li>

                        </ul>
                        <ul class="navbar-nav mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link fw-bold" href="logout.php">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
<?php } ?>
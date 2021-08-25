<?php

date_default_timezone_set('Asia/Dhaka');
ob_start();
session_start();
if(!isset($_SESSION['userData'])){
    header('Location: index.php');
    exit();
}

$table      = 'todo';
$primaryKey = 'id';
$userId     = $_SESSION['userData']['id'];
$where      = "user_id='$userId'";


$columns = array(
    array( 'db' => 'id',           'dt' => 0 ),
    array( 'db' => 'title',        'dt' => 1 ),
    array( 'db' => 'start_date',   'dt' => 2 ),
    array( 'db' => 'end_date',     'dt' => 3 ),
    array( 'db' => 'status',        'dt' => 4,
           'formatter' => function($d, $row){
               $status = ($d==0) ? 'Incomplete' : 'Completed';
               return $status;
           }
         ),
    array( 'db' => 'id',        'dt' => 5,
         'formatter' => function($d, $row){
             return 'Too Lazy to implement!';
         }
        ),
);



$sql_details = array(
    'user' => 'root',
    'pass' => '',
    'db'   => 'comeback_todo_project',
    'host' => '127.0.0.1'
);

require( 'ssp.class.php' );

echo json_encode(
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $where )
);

ob_end_flush();
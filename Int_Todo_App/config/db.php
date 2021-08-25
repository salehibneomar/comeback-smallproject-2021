<?php
    $HOST     = '127.0.0.1';
    $USER     = 'root';
    $PASSWORD = '';
    $DB       = 'comeback_todo_project';

    $db_conn  = new mysqli($HOST, $USER, $PASSWORD, $DB);

    if(!$db_conn){
        echo $db_conn->connect_error;
    }



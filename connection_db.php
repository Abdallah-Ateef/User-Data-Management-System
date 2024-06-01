<?php

try{
    $connection_db=new pdo('mysql:host=localhost;dbname=users_app','root','',array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}catch(PDOException $e){
    echo "Failed to connect to your database";
}
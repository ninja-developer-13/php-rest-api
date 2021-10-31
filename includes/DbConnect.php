<?php
/**
* Database configuration
* @author Prabakaran
*/
function getDB() {
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="rest_api_db";
    $conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8;", $dbuser, $dbpass);   
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    return $conn;
}
?>
<?php
/**
 * Handling edit operations
 *
 * @author Prabakaran
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
require_once("includes/DBConnect.php");
require_once("includes/DBHandler.php");
$item = new DBHandler();

$book_name = htmlspecialchars(strip_tags($_POST['book_name']));
$author_name = htmlspecialchars(strip_tags($_POST['author_name']));
$published_year = htmlspecialchars(strip_tags($_POST['published_year']));
$id = $_GET['id'];
$updateBook = $item->updateBooks($book_name, $author_name, $published_year, $id);
if ($updateBook > 0) {
    http_response_code(200);
    echo json_encode(
        array("code" => 200, "error" => false, "message" => 'Record Updated successfully.')
    );
} else {
    http_response_code(400);
    echo json_encode(
        array("code" => 400, "error" => false, "message" => 'could not be updated')
    );
}

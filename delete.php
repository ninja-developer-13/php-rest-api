<?php
/**
 * Handling delete operations
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
$items = new DBHandler();
$id = $_GET['id'];
$records = $items->deleteBook($id);
if ($records > 0) {
    http_response_code(200);
    echo json_encode(
        array("code" => 200, "error" => false, "message" => "Book Deleted successfully")
    );
} else {
    http_response_code(400);
    echo json_encode(
        array("code" => 400, "error" => true, "message" => "Failed to delete or not found the record")
    );
}

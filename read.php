<?php
/**
 * Handling read operations
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
$records = $items->getBooks();
if (!empty($records)) {
    http_response_code(200);
    echo json_encode(
        array("code" => 200, "error" => false, "output" => $records)
    );
} else {
    http_response_code(404);
    echo json_encode(
        array("code" => 404, "error" => true, "message" => "No record found.")
    );
}

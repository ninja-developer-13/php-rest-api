<?php
/**
 * Handling database operations
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
require_once("includes/DbConnect.php");
class DBHandler
{
    // Table
    private $db_table = "book";
    // Columns
    public $id;
    public $book_name;
    public $author_name;
    public $published_year;
    public $created;

    public function __construct()
    {
        $this->dbpdo = getDB();
    }
    // GET ALL
    public function getBooks()
    {
        $stmt = $this->dbpdo->prepare("SELECT id, book_name, author_name, published_year, created FROM " . $this->db_table . "");
        $stmt->execute();
        $num_rows = $stmt->rowCount();
        if ($num_rows > 0) {
            $tmp = [];
            $book_array = [];
            while ($result_set = $stmt->fetch(PDO::FETCH_OBJ)) {
                $tmp['id'] =  $result_set->id;
                $tmp['book_name'] =  $result_set->book_name;
                $tmp['author_name'] =  $result_set->author_name;
                $tmp['published_year'] =  $result_set->published_year;
                $tmp['created'] =  $result_set->created;
                $book_array[] = $tmp;
            }
            return $book_array;
            exit;
        } else {
            return NULL;
        }
    }
    public function insertBooks($field_one, $field_two, $field_three, $field_four)
    {
        $stmt1 = $this->dbpdo->prepare("INSERT INTO " . $this->db_table . "(book_name, author_name, published_year, created) values(:field_one, :field_two, :field_three, :field_four)");
        $stmt1->bindParam(":field_one", $field_one);
        $stmt1->bindParam(":field_two", $field_two);
        $stmt1->bindParam(":field_three", $field_three);
        $stmt1->bindParam(":field_four", $field_four);
        $result = $stmt1->execute();
        return $this->dbpdo->lastInsertId();
    }
    public function deleteBook($field_one)
    {
        $stmt1 = $this->dbpdo->prepare("DELETE FROM " . $this->db_table . " WHERE id = :field_one");
        $stmt1->bindParam(":field_one", $field_one);
        $result = $stmt1->execute();
        return  $stmt1->rowCount();
    }
    public function updateBooks($field_one, $field_two, $field_three, $field_four)
    {
        $stmt1 = $this->dbpdo->prepare("UPDATE " . $this->db_table . " SET book_name=:field_one, author_name=:field_two, published_year=:field_three WHERE id = :field_four");
        $stmt1->bindParam(":field_one", $field_one);
        $stmt1->bindParam(":field_two", $field_two);
        $stmt1->bindParam(":field_three", $field_three);
        $stmt1->bindParam(":field_four", $field_four);
        $result = $stmt1->execute();
        return $stmt1->rowCount();
    }
}

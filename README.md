# php-rest-api
 How to Make Simple Crud Rest Api in PHP with Mysql?
- October 30, 2021

What is an API?
API stands for application programming interface. It allows two applications to communicate with one another to access data. Every action you take on your phone, like sending a direct message or checking the score of the baseball game, uses an API to access and deliver that information.

It is used to communicate with the database via php extensions. API is just a collection of protocols and tools for making a software application. According to me API is the simple way to interact with allocations easily.

What is Rest API?
Rest Stands for Representational state transfer. REST is a software system for providing the data to different kind of applications. The web service system produce status code response in JSON or XML format.

A RESTful API is an architectural style for an application program interface (API) that uses HTTP requests to access and use data. That data can be used to GET, PUT, POST and DELETE data types, which refers to the reading, updating, creating and deleting of operations concerning resources.

Methods
The four main HTTP methods (GET, PUT, POST, and DELETE) can be mapped to CRUD operations as follows:

    GET retrieves the representation of the resource at a specified URI. GET should have no side effects on the server.
    PUT updates a resource at a specified URI. PUT can also be used to create a new resource at a specified URI, if the server allows clients to specify new URIs. For this tutorial, the API will not support creation through PUT.
    POST creates a new resource. The server assigns the URI for the new object and returns this URI as part of the response message.
    DELETE deletes a resource at a specified URI.

Let’s create REST API example without any PHP framework

Rest details are as follows:

Lets use following files for this rest api tutorial,










 

Steps:
1. Create a database named rest_api_db.

    Microsoft Windows [Version 10.0.18363.1139]
    (c) 2019 Microsoft Corporation. All rights reserved.

    C:\Users\PRABAKARAN>cd c:\xampp\mysql\bin

    c:\xampp\mysql\bin>mysql.exe -u root --password
    Enter password:
    Welcome to the MariaDB monitor.  Commands end with ; or \g.
    Your MariaDB connection id is 2
    Server version: 10.1.31-MariaDB mariadb.org binary distribution

    Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

    Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

    MariaDB [(none)]> CREATE DATABASE rest_api_db;
    Query OK, 1 row affected (0.01 sec)


2.Create a Book Table.

    MariaDB [(none)]> use rest_api_db;
    Database changed
    MariaDB [rest_api_db]> CREATE TABLE `book` (
        ->   `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
        ->   `book_name` varchar(256) NOT NULL,
        ->   `author_name` varchar(50) DEFAULT NULL,
        ->   `published_year` int(11) NOT NULL,
        ->   `created` datetime NOT NULL
        -> ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT = 1;
    Query OK, 0 rows affected (0.01 sec)


3. Insert data into book table

    INSERT INTO `book` (`id`, `book_name`, `author_name`, `published_year`, `created`) VALUES
    (1, 'Wings of fire', 'Dr.APJ.Abdul Kalam', 1999, '2021-10-17 18:45:02'),
    (2, 'The Great Indian Novel', 'Shashi Tharoor', 1989, '2021-10-17 18:45:02'),
    (3, 'Ponniyin Selvan', 'Kalki Krishnamurthy', 1954, '2021-10-17 18:45:02'),
    (6, 'hellom', 'hi', 2000, '2021-10-19 14:51:47');


4. Create a project folder book-curd-api-rest-php.

5.  Create includes folder under the project folder.

6. Create DbConnect.php with the following code in the project folder.

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
        $conn = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8;", $dbuser, 
 $dbpass);   
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        return $conn;
    }
    ?>


7. Create DbHandler.php with the following code in the project folder.
   
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



 8.Create read.php inside the project folder with the following code.
   
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


 9. Create create.php inside project folder.
     
    <?php
    /**
     * Handling data insert operations
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
    $created = date('Y-m-d H:i:s');
    $insertBook = $item->insertBooks($book_name, $author_name, $published_year, $created);
    if ($insertBook > 0) {
        http_response_code(200);
        echo json_encode(
            array("code" => 200, "error" => false, "message" => 'Record created successfully.')
        );
    } else {
        http_response_code(400);
        echo json_encode(
            array("code" => 400, "error" => false, "message" => 'could not be created')
        );
    }


10.Create edit.php inside project folder.
     
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


11.Create delete.php inside project folder.
     
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


Your REST API CRUD is ready now. You can test the APIs by using the postman app. Open any restclient and test the fourAPIs.

Test Read API:

http://localhost/book-curd-api-rest-php/read.php
https://blogger.googleusercontent.com/img/a/AVvXsEiy_NPjw5Ad084cwH69A5ujIlhcZHMoid7PV6kInLprmKvSnIFGzJsRv99fgiOz2WOPAQoX7KScwkp7EtBnKgDiPv4ja4pmTfBWA0_rIqC9VjpQTP0TplcMQoWddIud-lb7qRurtuTeFxlU3_BN5MdP3EOdYGQipOZ-owPvxx18QopLyJAbhl4qgXNOqQ=s16000

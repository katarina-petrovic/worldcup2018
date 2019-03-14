<?php
/**
 * Description of Database
 *
 * @author Kaca
 */

class Database {
    public $conn;

    function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "football2018";
        // Create connection
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->$conn->error);
        }
    }

    function __destruct() {
        $this->conn->close();
    }
}

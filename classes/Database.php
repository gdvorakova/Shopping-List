<?php

require_once('db_config.php');

class Database {
    public $connection;

    function __construct() {
        //$conn = mysql_connect('localhost', 'root', 'alkonvt123');

        // when object is created
        // connect to the database
        echo $db_config['server'];
        //$this->connection = new mysqli($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
        $this->connection = new mysqli('127.0.0.1', 'root', 'alkonvt123', 'shoppingcart');
        if ($this->connection->connect_error) {
            die("Could not connect to the database");
        }
    }

    function __destruct(){
        if ($this->connection !== null) {
            $this->connection->close();
        }
    }

    function getList() {
        $sql = "SELECT * from items";
        $result = $this->connection->query($sql);

        // return array of associatve array
        while($item = $result->fetch_assoc())
        {
            $items[] = $item;
        }
        return $items;

        /*foreach ($result as $value) {
            echo $value['name'];
        }*/
    }

    function select($searchString){
        $stmt = $this->connection->prepare('SELECT name FROM items WHERE name = ?') or handle_error($this->connection);
        $searchStringVar = $searchString . "%"; // !
        $stmt->bind_param('s', $searchStringVar) or handle_error($this->connection); // !
        $stmt->execute() or handle_error($this->connection);
        $query_result = $stmt->get_result() or handle_error($this->connection);

        while ($row = $query_result->fetch_assoc()) {
            $items[] = $row['name'];
        }
        return $items;
    }
    
    function query() {
        $result = $this->connection->query("SELECT * from items WHERE name = 'beer' ");

        if (!$result) {
            die("<p>Error in listing tables: " . mysql_error() . "</p>");
        }

        return $result;
    }
}
?>
<?php

include_once(getcwd() .'/classes/Database.php');

class ItemModel {
    private $db;

    function __construct(){
        $this->db = new Database();
    }

    function getAllItems() {
        $sql = "SELECT * from items";
        $result = $this->db->connection->query($sql);

        // return array of associatve array
        while($item = $result->fetch_assoc())
        {
            $items[] = $item;
        }
        return $items;
    }

    function getShoppingList() {
        $sql = 'SELECT items.id, items.name, list.amount from list JOIN items on items.id=list.id';
        $result = $this->db->connection->query($sql);

        // return array of associatve array
        while($item = $result->fetch_assoc())
        {
            $items[] = $item;
        }
        return $items;
    }

    function deleteItem($id) {
        $sql = 'DELETE FROM list WHERE id=' . $id;

        if (!$this->db->connection->query($sql) === TRUE) {
            echo "Error deleting record: " . $this->db->connection->error;
        }
    }

    function saveAmount($id, $amount) {
        $sql = 'UPDATE list SET amount=' . $amount . ' WHERE id=' . $id;

        if (!$this->db->connection->query($sql) === TRUE) {
            echo "Error changing amount of item with id " . $id . ": " . $this->db->connection->error;
        }
    }

    function addItem($name, $amount) {
    }
}

?>
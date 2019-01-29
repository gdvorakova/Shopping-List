<?php

include_once(getcwd() .'/classes/Database.php');

class ItemModel {
    private $db;

    function __construct(){
        $this->db = new Database();
    }

    function getAllItems() {
        $sql = "SELECT * from items";
        $result = $this->db->connection->query($sql) or $this->handle_error($this->db->connection);

        $items = $this->getAssociativeArray($result);
    
        return $items;
    }

    function getShoppingList() {
        $sql = 'SELECT list.id, items.name, list.amount, list.position from list JOIN items on items.id=list.item_id';
        $result = $this->db->connection->query($sql) or $this->handle_error($this->db->connection);

        $items = $this->getAssociativeArray($result);

        // sort by position key
        usort($items, function ($item1, $item2) {
            return $item1['position'] <=> $item2['position'];
        });

        return $items;
    }

    function deleteItem($id) {
        // update positions
        $this->updatePositionsAfterDelete($id);

        $sql = 'DELETE FROM list WHERE id=' . $id;

        if (!$this->db->connection->query($sql) === TRUE) {
            $this->handle_error($this->db->connection);
        }
    }

    function updatePositionsAfterDelete($id) {
        $sql = "SELECT id, position FROM list WHERE position > ALL (SELECT position FROM list WHERE id='$id')";
        $result = $this->db->connection->query($sql) or $this->handle_error($this->db->connection);

        $items = $this->getAssociativeArray($result);

        foreach($items as $item) {
            $position = (int)$item['position'] - 1;
            $id = $item['id'];
            $sqlUpdate = "UPDATE list SET position='$position' WHERE id='$id'";
            if (!$this->db->connection->query($sqlUpdate) === TRUE) {
                $this->handle_error($this->db->connection);
            }
        }
    }

    function saveAmount($id, $amount) {
        $stmt = $this->db->connection->prepare("UPDATE list SET amount=? WHERE id=" . $id) or $this->handle_error($this->db->connection);
        $stmt->bind_param('i', $amount) or $this->handle_error($this->db->connection); 
        $stmt->execute() or $this->handle_error($this->db->connection);
    }

    function addItem($name, $amount) {
        // first try to add this into items table
        $stmt = $this->db->connection->prepare("INSERT IGNORE INTO items SET name=?") or $this->handle_error($this->db->connection);
        $stmt->bind_param('s', $name) or $this->handle_error($this->db->connection);
        $stmt->execute() or $this->handle_error($this->db->connection);
        
        // get inserted item id
        $sqlGetInsertedItemId = "SELECT id from items WHERE name='$name'";
        $result = $this->db->connection->query($sqlGetInsertedItemId) or $this->handle_error($this->db->connection);
        $row = $result->fetch_assoc();

        $itemId = $row['id'];

        // get number of items in table items
        $sqlGetListCount = 'SELECT COUNT(ID) as total from list';
        $data = $this->db->connection->query($sqlGetListCount) or $this->handle_error($this->db->connection);

        $position = (int)$data->fetch_assoc()['total'] + 1;

        // insert this item into list table
        $sqlInsertToList = "INSERT INTO list (item_id, amount, position) VALUES ('$itemId', '$amount', '$position')";
        
        if(!$this->db->connection->query($sqlInsertToList) === TRUE) {
            $this->handle_error($this->db->connection);
        }
    }

    function getAssociativeArray($result) {
        // return array of associatve array
        while($item = $result->fetch_assoc())
        {
            $items[] = $item;
        }
        return $items;
    }

    function swap($id1, $id2) {
        $sqlPosition1 = "SELECT position FROM list WHERE id='$id1'";
        $sqlPosition2 = "SELECT position FROM list WHERE id='$id2'";

        $position1 = (int)$this->db->connection->query($sqlPosition1)->fetch_assoc()['position'];
        $position2 = (int)$this->db->connection->query($sqlPosition2)->fetch_assoc()['position'];

        $sqlUpdate1 = "UPDATE list SET position='$position2' WHERE id='$id1'";
        $sqlUpdate2 = "UPDATE list SET position='$position1' WHERE id='$id2'";

        if (!$this->db->connection->query($sqlUpdate1) === TRUE) 
            $this->handle_error($this->db->connection);
        if (!$this->db->connection->query($sqlUpdate2) === TRUE)  
            $this->handle_error($this->db->connection);
    }

    function handle_error($connection) {
        die("Query error: " . $connection->error);
    }
}

?>
<?php

include_once('controllers/ShoppingListController.php');

$viewFilePath = getcwd() . '/views/ShoppingList.php';

$controller = new ShoppingListController($viewFilePath);

if(isset($_GET['action'])) {
    if ($_GET['action'] == 'delete') {
        $controller->actionDelete($_GET['id']);
    }

    if ($_GET['action'] == 'save-amount') {
        $id = $_GET['id'];
        $amount = $_GET['amount'];
    
        $controller->actionSaveAmount($id, $amount);
    }

    if ($_GET['action'] == 'swap') {
        $id1 = $_GET['id1'];
        $id2 = $_GET['id2'];
    
        $controller->actionSwap($id1, $id2);
    }
}
else if(isset($_POST['submit'])) {
    echo $_POST['name'];
    echo $_POST['amount'];

    $name = $_POST['name'];
    $amount = $_POST['amount'];

    $controller->actionAddItem($name, $amount);
}
else {
    $items = $controller->getShoppingList();
    $all_items = $controller->getAllItems();

    $controller->render(array('items' => $items, 'all_items' => $all_items)); 
}

?>
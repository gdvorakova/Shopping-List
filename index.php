<?php

include_once('Controllers/ShoppingListController.php');

$viewFilePath = getcwd() . '/Views/ShoppingList.php';

$controller = new ShoppingListController($viewFilePath);

if(isset($_GET['action']) &&  $_GET['action'] == 'delete') {
    $controller->actionDelete($_GET['id']);
}
else if(isset($_GET['action']) && $_GET['action'] == 'save-amount') {
    $controller->actionSaveAmount($_GET['id'], $_GET['amount']);
}
else {
    $items = $controller->getShoppingList();
    $all_items = $controller->getAllItems();

    $controller->render(array('items' => $items, 'all_items' => $all_items)); 
}

?>
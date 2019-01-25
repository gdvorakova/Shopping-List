<?php

include_once(getcwd() . '/models/ItemModel.php');
include_once(getcwd() . '/controllers/BaseController.php');

class ShoppingListController extends BaseController {
    function __construct($file) {       
        parent::__construct($file);

        $this->model = new ItemModel();
    }

    function getShoppingList() {
        $items = $this->model->getShoppingList();

        return $items;
    }

    function getAllItems() {
        $items = $this->model->getAllItems();

        return $items;
    }


    function actionDelete($id) {
        if(!is_null($id)) {
            $this->model->deleteItem($id);
        }
    }

    function actionSaveAmount($id, $amount) {
        if (!is_null($id)) {
            $this->model->saveAmount($id, $amount);
        }
    }

    function actionAddItem($name, $amount) {
        $this->model->addItem($name, $amount);
    }

    function actionSwap($id1, $id2) {
        $this->model->swap($id1, $id2);
    }
}

?>
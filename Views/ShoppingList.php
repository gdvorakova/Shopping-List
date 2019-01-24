<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Gabriela Dvořáková">
        <title>Shopping Bag</title>
        <link rel="stylesheet" media="all" href="styles/styles.css" type="text/css"/>
        <script src="scripts/script.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">
    </head>
    <body class="container">

        <div class="shopping-bag">
             <!-- Main header -->
            <header>
                <h1>Shopping Bag</h1>     
            </header>

            <?php
                foreach ($items as $item): ?>
                    <div class="item" id=<?php echo $item['id']?> >
                        <div class="button">
                            <button class="delete-button" type="button" onclick="deleteItem(this)">&times</button>
                        </div>

                        <div class="item-name">
                            <span><?php echo $item['name']; ?></span>
                        </div>

                        <div class="quantity">
                            <button class="minus-button" type="button" name="button" onclick="decreaseQuantity(this)">
                                -
                            </button>
                            <input type="text" name="name" value=<?php echo $item['amount'];?> id="amount">
                            <button class="plus-button" type="button" name="button" onclick="increaseQuantity(this)">
                                +
                            </button>
                        </div>

                        <button class="save-changes-button" type="button" name="button" disabled="disabled" onclick="saveChanges(event)">
                            <span class="save-icon">
                                <i class="fas fa-check"></i>
                            </span>
                            Save
                        </button>
                        
                    </div>
            <?php endforeach; ?>
        </div>       

        <div class="form">
            <h1> Add items </h1>
            <div class="form-fields">
                    <div class="field">
                        <label class="label">Item</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="e.g. banana" list="all_items" id="name">
                                <datalist id="all_items">
                                    <?php foreach ($all_items as $item): 
                                        $value = $item['name']; ?>
                                        <option value= <?php echo $value;?> >
                                        <? echo $value; ?>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>  
                    </div>

                    <div class="field">
                        <label class="label">Amount</label>
                            <div class="control">
                                <input class="input" type="text" placeholder="e.g. 5" id="amount">
                            </div>  
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" class="form-submit-button" value="Submit">
                        </div>  
                    </div>
            </div>
        </div>
    </body>
</html>
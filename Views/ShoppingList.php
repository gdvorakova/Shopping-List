<!DOCTYPE html> 
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Gabriela Dvořáková">
        <title>Shopping Bag</title>
        <link rel="stylesheet" media="all" href="styles/styles.css" type="text/css"/>
        <script src="scripts/script.js" type="text/javascript"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">
    </head>

    <body class="container" class='dragContainer'>
        <div class="shopping-list">
            <header>
                <h1>Shopping list</h1>     
            </header>

            <?php
                foreach ($items as $item): ?>
                    <div class="item" id=<?php echo htmlspecialchars($item['id'])?> 
                    draggable=true ondragstart="drag(event)" ondragover="allowDrop(event)" ondrop="drop(event)">

                        <div class="button">
                            <button class="delete-button" type="button" onclick="deleteItem(this)">&times</button>
                        </div>

                        <div class="item-name">
                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                        </div>

                        <div class="amount">
                            <button class="minus-button" type="button" name="button" onclick="decreaseAmount(this)">
                                <span class="inc-dec-icons">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </span>
                            </button>
                            <input type="text" name="name" value=<?php echo htmlspecialchars($item['amount']);?> id="amount" readonly>
                            <button class="plus-button" type="button" name="button" onclick="increaseAmount(this)">
                                <span class="inc-dec-icons">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </span>
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

        <div class="add-items">
            <h1> Add items </h1>
            <iframe name="hiddenFrame" class="hide"></iframe>

            <form action="index.php" method="POST" target="hiddenFrame" id="add-item-form">

                <div class="field" id="name-field">
                    <label class="label">Item</label>
                    <div class="control">
                        <input class="input" name="name" type="text" placeholder="e.g. banana" list="all_items" 
                        onkeyup="checkForm()" minlength="1">
                        <datalist id="all_items">
                            <div class=options>
                            <select>
                                <?php foreach ($all_items as $item): 
                                    $value = $item['name']; ?>
                                    <option value= <?php echo htmlspecialchars($value);?> >
                                    <? echo $value; ?>
                                <?php endforeach; ?>
                            </select>
                            </div>
                        </datalist>
                    </div>  
                </div>

                <div class="field" id="amount-field">
                    <label class="label">Amount</label>
                    <div class="control">
                        <input class="input" name="amount" id="amount-input" type="text" placeholder="e.g. 5" 
                        minlength="1" onkeyup="checkForm()">
                    </div>  
                </div>

                <div class="field" id="button-field">
                    <div class="control">
                        <input type="submit" name="submit" id="submit-input" 
                        class="form-submit-button" value="Submit" disabled>
                    </div>  
                </div>
                
            </form>
        </div>
    </body>
</html>